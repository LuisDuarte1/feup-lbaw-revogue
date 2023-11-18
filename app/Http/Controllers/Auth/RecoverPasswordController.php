<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecoverPasswordController extends Controller 
{

    public function showRecoverPasswordForm()
    {
        return view('auth.recover-password');
    }


    public function sendEmailPasswordRecovery(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email',],
        ]);

        $email = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]); 


    }


}