<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this import statement if not already present
use Stripe\Tax\Settings;

// Add this import statement

class SettingsController extends Controller
{
    public function getPaymentSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }

        $settings = $user->settings['payment'];

        return $settings;
    }

    public function getGeneralSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = ($user->settings['general']);

        return $settings;
    }

    public function getShippingSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = ($user->settings['shipping']);

        return $settings;
    }

    public function getProfileSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings->profile, true);

        return $settings;
    }

    public function updatePaymentSettings(Request $request)
    {
        $user = User::find(Auth::id());

        if ($user === null) {
            return redirect('/login');
        }

        $payment_settings = SettingsController::getPaymentSettings();
        $settings = $user->settings;

        foreach ($request->all() as $key => $value) {
            $payment_settings[$key] = $value;
        }

        $settings['payment'] = $payment_settings;

        $user->settings = $settings;

        $user->save();

        return redirect('/settings/payment');
    }

    // ...

    public function updateGeneralSettings(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['general_'.$request->key] = $request->value;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/settings/general');
    }

    public function updateShippingSettings(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['shipping_'.$request->key] = $request->value;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/settings/shipping');
    }

    public function resetPaymentSettings()
    {
        $user = User::find(Auth::id());

        if ($user === null) {
            return redirect('/login');
        }

        $payment_settings = SettingsController::getPaymentSettings();
        $settings = $user->settings;

        foreach ($payment_settings as $key => $value) {
            $payment_settings[$key] = null;
        }

        $settings['payment'] = $payment_settings;

        $user->settings = $settings;

        $user->save();

        return redirect('/settings/payment');
    }

    public function resetGeneralSettings()
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['general_currency'] = null;
        $settings['general_currency_symbol'] = null;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/settings/general');
    }

    public function resetShippingSettings()
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['shipping_address'] = null;
        $settings['shipping_city'] = null;
        $settings['shipping_state'] = null;
        $settings['shipping_zip'] = null;
        $settings['shipping_country'] = null;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/settings/shipping');
    }

    public function resetProfileSettings()
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);
        $settings['profile_name'] = null;
        $settings['profile_email'] = null;
        $settings['profile_phone'] = null;
        $settings['profile_address'] = null;
        $settings['profile_city'] = null;
        $settings['profile_state'] = null;
        $settings['profile_zip'] = null;
        $settings['profile_country'] = null;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/settings/profile');
    }

    public function ShippingSettings()
    {
        $user = Auth::user();
        $settings = SettingsController::getShippingSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'shipping']);
    }

    public function GeneralSettings()
    {
        $user = Auth::user();
        $settings = SettingsController::getGeneralSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'general']);
    }

    public function PaymentsSettings()
    {
        $user = Auth::user();

        $settings = SettingsController::getPaymentSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'payment']);
    }

    /*public function ProfileSettings()
    {
        $user = Auth::user();

        $settings = SettingsController::getProfileSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'profile']);
    }*/

}
