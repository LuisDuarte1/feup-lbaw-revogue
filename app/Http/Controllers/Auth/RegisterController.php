<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View; // Add this import

class RegisterController extends Controller
{
    /**
     * Display a login form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        Validator::extend('olderThan', function ($attribute, $value, $parameters) {
            $minAge = (! empty($parameters)) ? (int) $parameters[0] : 13;

            return (new DateTime)->diff(new DateTime($value))->y >= $minAge;
        });

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
            'date_birth' => 'required|date|olderThan:13|before:today',
        ], [
            'date_birth' => 'You must be at least 13 years old to register.',
            'date_birth' => 'Your birth date must be before today.',
        ]);

        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator)->withInput();
        }
        $settings = User::getDefaultSettings();

        $user = User::create([
            'username' => $request->username,
            'display_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_birth' => $request->date_birth,
            'account_status' => 'needsConfirmation',
            //TODO: add settings schema default
            'settings' => $settings,
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        event(new Registered($user));

        return redirect('/login/email-confirmation');
    }
}
