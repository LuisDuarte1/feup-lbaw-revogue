<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function getPaymentSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $list = [];
        foreach ($settings as $key => $value) {
            if (strpos($key, 'payment_') === 0) {
                array_push($list, ['key' => $key, 'value' => $value]);
            }
        }

        return $list;
    }

    public function getGeneralSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $list = [];
        foreach ($settings as $key => $value) {
            if (strpos($key, 'general_') === 0) {
                array_push($list, ['key' => $key, 'value' => $value]);
            }
        }

        return $list;
    }

    public function GeneralSettings(Request $request)
    {
        $user = Auth::user();
        $settings = SettingsController::getGeneralSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'general']);
    }

    public function PaymentsSettings(Request $request)
    {
        $user = Auth::user();

        $settings = SettingsController::getPaymentSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'payment']);
    }
}
