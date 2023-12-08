<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this import statement if not already present

// Add this import statement

class SettingsController extends Controller
{
    public function getSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);

        return $settings;
    }

    public function getPaymentSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        //$settings = $user->settings['payment'];
        $settings = json_decode($user->settings);
        dd($settings);

        return $settings;
    }

    public function getGeneralSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);

        return $settings;
    }

    public function getShippingSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);

        return $settings;
    }

    public function getProfileSettings()
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);

        return $settings;
    }

    public function updatePaymentSettings(Request $request)
    {
        $user = User::find(Auth::id());

        if ($user === null) {
            return redirect('/login');
        }
        $settings = json_decode($user->settings, true);

        $settings['company_name'] = $request->get('company_name');
        $settings['company_address'] = $request->get('company_address');

        $user->settings = json_encode($settings);
        $user->save(); // Call the save() method to persist the changes

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
