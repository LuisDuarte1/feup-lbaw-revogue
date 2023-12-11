<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this import statement if not already present

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

    // GENERAL SETTINGS

    public function delete_account(Request $request)
    {
        $user = Auth::user();

        /* if (Hash::check($request->password, $user->password)) {
            Auth::logout();
            Session::flush();
             $user->delete();

             return redirect()->route('landing')->with('success', 'Account deleted successfully');
         } else {
             return back()->withErrors(['password' => 'The password is incorrect']);
         }*/
    }

    public function change_password(Request $request)
    {
        $user = Auth::user();

        /* if (Hash::check($request->password, $user->password)) {
             $user->password = Hash::make($request->new_password);
             $user->save();

             return redirect()->route('landing')->with('success', 'Password changed successfully');
         } else {
             return back()->withErrors(['password' => 'The password is incorrect']);
         }*/
    }

    // END OF GENERAL SETTINGS

    public function updateShippingSettings(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }

        $shipping_settings = SettingsController::getShippingSettings();

        $settings = $user->settings;

        foreach ($request->all() as $key => $value) {
            $shipping_settings[$key] = $value;
        }

        $settings['shipping'] = $shipping_settings;

        $user->settings = $settings;

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
        $general_settings = SettingsController::getGeneralSettings();
        $settings = $user->settings;

        foreach ($general_settings as $key => $value) {
            $general_settings[$key] = null;
        }

        $settings['general'] = $general_settings;

        $user->settings = $settings;

        $user->save(); // Save the updated user object

        return redirect('/settings/general');
    }

    public function resetShippingSettings()
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }
        $shipping_settings = SettingsController::getShippingSettings();
        $settings = $user->settings;

        foreach ($shipping_settings as $key => $value) {
            $shipping_settings[$key] = null;
        }

        $settings['shipping'] = $shipping_settings;

        $user->settings = $settings;

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
        $settings['name'] = null;
        $settings['email'] = null;
        $settings['phone'] = null;
        $settings['address'] = null;
        $settings['city'] = null;
        $settings['state'] = null;
        $settings['zip'] = null;
        $settings['country'] = null;
        $user->settings = json_encode($settings);
        $user->save(); // Save the updated user object

        return redirect('/profile/complete');
    }

    public function ShippingSettings()
    {
        $user = Auth::user();
        $settings = SettingsController::getShippingSettings();

        return view('pages.shippingSettings', ['settings' => $settings, 'user' => $user, 'tab' => 'shipping']);
    }

    public function GeneralSettings()
    {
        $user = Auth::user();
        $settings = SettingsController::getGeneralSettings();

        return view('pages.generalSettings', ['settings' => $settings, 'user' => $user, 'tab' => 'general']);
    }

    public function PaymentsSettings()
    {
        $user = Auth::user();

        $settings = SettingsController::getPaymentSettings();

        return view('pages.settings', ['settings' => $settings, 'user' => $user, 'tab' => 'payment']);
    }

    public function ProfileSettings()
    {
        $user = Auth::user();
        // if profile is not complete redirect to profile/complete
        //$settings = SettingsController::getProfileSettings();

        return redirect()->route('complete-profile');

    }
}
