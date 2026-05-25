<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'mobile' => ['required', 'string', 'regex:/^(?:\+63|09)\d{9}$/'],
            'password' => ['required', 'string', 'min:6', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9]).+$/', 'confirmed'],
        ], [
            'mobile.regex' => 'Phone number must start with +63 or 09 and be 11 digits long.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one symbol.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !$this->phoneMatchesUser($request->mobile, $user)) {
                $validator->errors()->add('mobile', 'The email and phone number do not match our records.');
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput($request->only('email', 'mobile'));
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()
            ->route('login')
            ->with('status', 'Password has been changed successfully. You can now log in.');
    }

    private function phoneMatchesUser(string $inputPhone, User $user): bool
    {
        $inputPhone = $this->normalizePhone($inputPhone);

        return collect([$user->mobile ?? null, $user->phone_number ?? null])
            ->filter()
            ->map(fn ($phone) => $this->normalizePhone($phone))
            ->contains($inputPhone);
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s\-\(\)]/', '', trim($phone));

        if (str_starts_with($phone, '09')) {
            return '+63' . substr($phone, 1);
        }

        if (str_starts_with($phone, '639')) {
            return '+' . $phone;
        }

        return $phone;
    }
}
