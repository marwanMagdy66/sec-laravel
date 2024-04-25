<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('login');
    }

    public function username()
    {
        $value = request()->input('userLogin');
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            request()->merge(["email" => $value]);
            return 'email';
        } else if (preg_match("/^[a-z,.'-]+$/", $value)) {
            request()->merge(["name" => $value]);
            return 'name';
         } 
        // else if (preg_match("/^01[0125][0-9]{8}$/", $value)) {
        //     // Encrypt the user input to match the encrypted phone numbers in the database
        //     $encryptedPhone = Crypt::encryptString($value);
        //     request()->merge(["phone" => $encryptedPhone]);
        //     return 'phone';
        // } 
        else {
            request()->merge(["email" => $value]);
            return 'email';
        }

    }

    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                'userLogin' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'userLogin.required' => 'the name/email is required'
            ]
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
           'userLogin' => [trans('auth.failed')],
        ]);
    }

}

