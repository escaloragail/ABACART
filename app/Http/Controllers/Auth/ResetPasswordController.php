<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).+$/', 'confirmed'],
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one symbol.',
        ];
    }
}
