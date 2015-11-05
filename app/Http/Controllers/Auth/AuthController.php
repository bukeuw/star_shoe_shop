<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use ReCaptcha\ReCaptcha;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberLoginRequest;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    protected $loginPath = '/login';
    protected $redirectPath = '/';
    protected $recaptcha_error;

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function authenticate(MemberLoginRequest $request)
    {
        if(!$this->getreCaptchaValidation($request)) {
            return $this->sendreCaptchaErrorResponse($request);
        }

        return $this->postLogin($request);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'g-recaptcha-response' => 'required'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Silahkan masukan email yang valid',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter',
            'email.unique' => 'Email sudah ada silahkan gunakan emai lain',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'password.min' => 'Password minimal 6 karakter',
            'g-recaptcha-response.required' => 'Silahkan verifikasi captch terlebih dahulu'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect user back to login page
     * with error message
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendreCaptchaErrorResponse(Request $request) {

        return redirect($this->loginPath())
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => 'Invalid captcha',
                'error_code' => $this->recaptcha_error
            ]);
    }

    /**
     * Get Google reCapcha validation response
     * 
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function getreCaptchaValidation(Request $request) {
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRET'));

        $response = $recaptcha->verify($recaptchaResponse, $request->ip());

        if(!$response->isSuccess()) {
            $this->recaptcha_error = $response->getErrorCodes();
        }

        return $response->isSuccess();
    }
}
