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
        //$settings = $user->settings['payment'];
        $settings = json_decode($user->settings);

        return $settings;
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

    public function getShippingSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $list = [];
        foreach ($settings as $key => $value) {
            if (strpos($key, 'shipping_') === 0) {
                array_push($list, ['key' => $key, 'value' => $value]);
            }
        }

        return $list;
    }

    public function updateGeneralSettings(Request $request)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['general_'.$request->key] = $request->value;
        $user->settings = json_encode($settings);
        //$user->save();

        return redirect('/settings/general');
    }

    public function updatePaymentSettings(Request $request)
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        //dd($settings);
        //dd($request);
        $settings['company_name'] = $request->value;
        //dd($settings);
        $user->settings = json_encode($settings);
        //$user->save();

        return redirect('/settings/payment');
    }

    public function ShippingSettings(Request $request)
    {
        $user = Auth::user();
        $settings = SettingsController::getShippingSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user]);
    }

    public function GeneralSettings(Request $request)
    {
        $user = Auth::user();
        $settings = SettingsController::getGeneralSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user]);
    }

    public function PaymentsSettings(Request $request)
    {
        $user = Auth::user();

        $settings = SettingsController::getPaymentSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user]);
    }
}
