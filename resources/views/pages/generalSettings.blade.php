@extends('layouts.app')

@section('content')
    <x-settingsNavbar :tab="$tab" />
    <header>
        <h1 class="title settings-title">General Settings</h1>
    </header>
    <div class="edit-settings-page">

        <form action="{{ route('settings.general.save') }}" method="POST" class="editForm" enctype="multipart/form-data">
            @csrf

            <div class="settings-wrapper column justify-center gap-2">


                <div class="settings-details column gap-2">
                    <div class="currency">
                        <label for="currency" required>Currency</label>
                        <input type="text" name="currency" id="currency" value={{ $settings['currency'] }}>
                    </div>
                    <div class="currency_symbol">
                        <label for="currency_symbol" required>Symbol</label>
                        <input type="text" name="currency_symbol" id="shipping_city"
                            value={{ $settings['currency_symbol'] }}>
                    </div>
                    <button class="submit-button"type="submit">Save</button>
        </form>

        <form action="{{ route('settings.general.reset') }}" method="POST" class="editForm">
            <button class="submit-button reset" type="submit">Reset</button>
        </form>

    </div>
    </div>
@endsection
