<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('webadmin')->check()) {
            return redirect('/admin');
        } else {
            return view('pages.admin.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('webadmin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('webadmin')->user();
            if ($user->account_status == 'needsConfirmation') {
                return redirect('/login/email-confirmation');
            }

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-login')
            ->withSuccess('You have logged out successfully!');
    }
}