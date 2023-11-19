<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

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
        $request->validate([
            'name' => 'required|string|max:250',
            'username' => 'required|string|max:250|unique:users',
            'email' => 'required|email|max:250|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'display_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_status' => 'needsConfirmation',
            //TODO: add settings schema default
            'settings' => json_encode([]),
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $request->session()->regenerate();
        event(new Registered($user));
        return redirect('/login/email-confirmation');
    }
}
