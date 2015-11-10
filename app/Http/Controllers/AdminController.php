<?php

namespace App\Http\Controllers;

use Auth;
use Lang;
use App\User;
use App\Contact;
use App\Transaction;
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
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
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Silahkan masukan email yang valid',
            'email.unique' => 'Email sudah digunakan silahkan masukan email lain',
            'password.required' => 'Password tidak boleh dikosongkan',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min' => 'Password minimal 6 karakter'
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
        // Stripe::setApiKey(env('STRIPE_SECRET'));

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

    public function getMessageList()
    {
        $messages = Contact::paginate(10);

        return view('tokostar.admin.messagelist', compact('messages'));
    }

    public function getAdminList()
    {
        $admins = User::where('is_admin', true)->get();

        return view('tokostar.admin.adminlist', compact('admins'));
    }

    protected function getChartData()
    {
        $transactions = Transaction::all();

        $data = (object) array(
            "Jan" => 0, "Feb" => 0, "Mar" => 0,
            "Apr" => 0, "May" => 0, "Jun" => 0,
            "Jul" => 0, "Aug" => 0, "Sep" => 0,
            "Oct" => 0, "Nov" => 0, "Dec" => 0
        );

        foreach($transactions as $transaction) {
            $monthName = $transaction->created_at->format('M');
            if(property_exists($data, $monthName)) {
                $data->{$monthName} += $transaction->total;
            }
        }

        return $data;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chartData = $this->getChartData();

        return view('tokostar.admin.dashboard', compact('chartData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tokostar.admin.admincreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules['create'], $this->messages['create']);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'is_admin' => true
        ]);

        \Session::flash('message', 'Admin baru berhasil ditambah');

        return redirect('/admin/manage');
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
        $admin = User::where('id', $id)
                            ->where('is_admin', true)
                            ->first();

        return view('tokostar.admin.adminedit', compact('admin'));
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
        $admin = User::where('id', $id)
                            ->where('is_admin', true)
                            ->first();

        $admin->update($request->all());

        \Session::flash('message', 'Admin berhasil diupdate');

        return redirect('/admin/manage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = User::where('id', $id)
                            ->where('is_admin', true)
                            ->first();

        if(\Auth::user()->id == $admin->id) {
            \Session::flash('message', 'Admin yang sedang aktif tidak dapat dihapus');
        } else {
            $admin->delete();
        }

        \Session::flash('message', 'Admin berhasil dihapus');

        return redirect('/admin/manage');
    }
}
