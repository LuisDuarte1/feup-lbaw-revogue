<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailConfirmationController extends Controller
{
    public static function obfuscate_email($email)
    {
        $em = explode('@', $email);
        $name = implode('@', array_slice($em, 0, count($em) - 1));
        $len = floor(strlen($name) / 2);

        return substr($name, 0, $len).str_repeat('*', $len).'@'.end($em);
    }

    //
    public function getPage(Request $request)
    {
        $user = Auth::user();
        if ($user->account_status !== 'needsConfirmation') {
            return redirect('/');
        }

        return view('pages.emailConfirmation', ['email' => EmailConfirmationController::obfuscate_email($user->email)]);
    }

    public function resendEmail(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'The verification email has been sent, check your inbox!');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/profile/complete');
    }
}
