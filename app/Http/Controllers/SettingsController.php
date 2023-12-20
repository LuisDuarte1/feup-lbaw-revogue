<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Monarobase\CountryList\CountryListFacade as Countries;

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

    public function deleteAccount(Request $request)
    {
        $user = User::find(Auth::id());
        if (Hash::check($request->password, $user->password)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Session::flush();
            $user->delete();

            return redirect()->route('login')
                ->withSuccess('You have logged out successfully!');
        } else {

            return redirect()->route('general-settings')->withErrors(['password' => 'The password is incorrect']);
        }
    }

    public function changePassword(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if (! Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect']);
        }

        User::whereId($user->id)->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password changed successfully');

    }

    public function updatePaymentSettings(Request $request)
    {
        $user = User::find(Auth::id());

        if ($user === null) {
            return redirect('/login');
        }

        $payment_settings = SettingsController::getPaymentSettings();
        $settings = $user->settings;

        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'bank_account_number' => 'required|regex:/^[0-9]+$/',
            'bank_account_name' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
            'bank_routing_number' => 'required|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->all() as $key => $value) {
            $payment_settings[$key] = $value;
        }

        $settings['payment'] = $payment_settings;

        $user->settings = $settings;

        $user->save();

        return redirect('/settings/payment');
    }

    public function updateShippingSettings(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user === null) {
            return redirect('/login');
        }

        $shipping_settings = SettingsController::getShippingSettings();

        $settings = $user->settings;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|regex:/^(?:[0-9\-\(\)\/\.]\s?){6,15}[0-9]{1}$/',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'zip-code' => 'required|regex:/^[A-Za-z0-9- ]{3,10}$/',
        ]);

        if ($validator->fails()) {

            return back()->withErrors($validator)->withInput();
        }

        foreach ($request->all() as $key => $value) {
            $shipping_settings[$key] = $value;
        }

        $settings['shipping'] = $shipping_settings;
        $user->settings = $settings;

        $user->save();

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

        $user->save();

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
        $user->save();

        return redirect('/profile/complete');
    }

    public function ShippingSettings()
    {
        $user = Auth::user();
        $settings = SettingsController::getShippingSettings();

        return view('pages.shippingSettings', ['settings' => $settings, 'user' => $user, 'tab' => 'shipping', 'countries' => Countries::getList('en')]);
    }

    public function GeneralSettings()
    {
        $user = Auth::user();

        return view('pages.generalSettings', ['user' => $user, 'tab' => 'general']);
    }

    public function PaymentsSettings()
    {
        $user = Auth::user();

        $settings = SettingsController::getPaymentSettings();

        return view('pages.paymentSettings', ['settings' => $settings, 'user' => $user, 'tab' => 'payment']);
    }

    public function ProfileSettings()
    {

        return redirect()->route('complete-profile');

    }
}
