@extends('layouts.app')

@section('content')
    <x-settingsNavbar :tab="$tab" />
    <header>
        <h1 class="title settings-title">Shipping Settings</h1>
    </header>
    <div class="edit-settings-page">

        <form action="{{ route('settings.shipping.save') }}" method="POST" class="editForm" enctype="multipart/form-data">
            @csrf

            <div class="settings-wrapper column justify-center gap-2">


                <div class="settings-details column gap-2">
                    <div class="address">
                        <label for="address" required>Shipping Address</label>
                        <input type="text" name="address" id="address" value={{ $settings['address'] }}>
                    </div>
                    <div class="city">
                        <label for="city" required>City</label>
                        <input type="text" name="city" id="city" value={{ $settings['city'] }}>
                    </div>
                    <div class="state">
                        <label for="state" required>State</label>
                        <input type="text" name="state" id="state" value={{ $settings['state'] }}>
                    </div>
                    <div class="zip">
                        <label for="zip" required>Zip</label>
                        <input type="text" name="zip" id="zip" value={{ $settings['zip'] }}>

                    </div>
                    <div class="country">
                        <label for="country" required>Country</label>
                        <input type="text" name="country" id="country" value={{ $settings['country'] }}>
                    </div>
                    <button class="submit-button"type="submit">Save</button>
        </form>

        <form action="{{ route('settings.shipping.reset') }}" method="POST" class="editForm">
            <button class="submit-button reset" type="submit">Reset</button>
        </form>

    </div>
    </div>
@endsection
