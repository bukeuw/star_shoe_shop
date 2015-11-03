<?php

namespace App\Http\Controllers;

use Auth;
use Lang;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\Balance;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminController extends Controller
{
    protected $redirectAfterLogout = '/admin/login';

    /**
     * Validation rule for admin login page and creating new admin account
     * 
     * @var array
     */
    protected $rules = [
        'create' => [
            'name' => 'required'
            'email' => 'required|email',
            'password' => 'required'
        ],
        'login' => [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required'
        ]
    ];

    /**
     * Validation messages for admin login page and creating admin account
     * 
     * @var array
     */
    protected $messages = [
        'create' => [
            'name.required' => 'Nama tidak boleh kosong'
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Silhkan masukan email yang valid',
            'password.required' => 'Password tidak boleh dikosongkan'
        ],
        'login' => [
            'email.required' => 'Nama tidak boleh kosong',
            'email.email' => 'Silahkan masukan email yang valid',
            'password.required' => 'Password tidak boleh kosong',
            'g-recaptcha-response.required' => 'Silahkan verifikasi captcha terlebih dahulu'
        ]
    ];

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $this->middleware('admin', ['except' => ['getLogin', 'postLogin']]);
        $this->middleware('guest', ['only' => ['getLogin', 'postLogin']]);
    }

    public function getLogin() {
        return view('tokostar.auth.adminlogin');
    }

    public function postLogin(Request $request) {
        $this->validate($request, $this->rules['login'], $this->messages['login']);

        // If reCaptcha validation fail, redirect user back to login form
        $recaptcha = $this->getreCaptchaValidation($request);

        if(!$recaptcha) {
            return $this->sendreCaptchaErrorResponse($request);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'is_admin' => true,
        ];

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }

        return redirect('/admin/login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $this->getFailedLoginMessage(),
            ]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $throttles
     * @return \Illuminate\Http\Response
     */
    protected function handleUserWasAuthenticated(Request $request, $throttles)
    {
        if ($throttles) {
            $this->clearLoginAttempts($request);
        }

        if (method_exists($this, 'authenticated')) {
            return $this->authenticated($request, Auth::user());
        }

        return redirect()->intended('/admin');
    }

    /**
     * Get the failed login message.
     *
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return 'Email atau password tidak valid';
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        Auth::logout();

        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

    /**
     * Determine if the class is using the ThrottlesLogins trait.
     *
     * @return bool
     */
    protected function isUsingThrottlesLoginsTrait()
    {
        return in_array(
            ThrottlesLogins::class, class_uses_recursive(get_class($this))
        );
    }

    /**
     * Redirect user back to login page
     * with error message
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendreCaptchaErrorResponse(Request $request) {

        return redirect('/admin/login')
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'Invalid captcha',
            ]);
    }

    /**
     * Get Google reCapcha validation response
     * 
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function getreCaptchaValidation(Request $request) {
        if($request->has('g-recaptcha-response')) {
            $captcha = $request->input('g-recaptcha-response');

            $gjson = file_get_contents(
                "https://www.google.com/recaptcha/api/siteverify?" .
                "secret=" . env('RECAPTCHA_SECRET') . 
                "&response=" . $captcha . 
                "&remoteip=" . $request->ip()
            );
            $response = json_decode($gjson, true);

            if($response['success'] == true) {
              return true;
            }
        }

        return false;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = Account::retrieve();
        $balance = Balance::retrieve();

        return view('tokostar.admin.dashboard', [
            'account' => $account,
            'balance' => $balance
        ]);
    }

    public function getAdminList()
    {
        $admin = User::where('is_admin', true)->get();

        return view('tokostar.admin.adminlist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
