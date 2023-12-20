@extends('layouts.app')

@section('content')
<x-settingsNavbar :tab="$tab" />
<div class="page-center">
    <div class="settings-wrapper">
        <h1 class="title">Shipping Settings</h1>
        <form action="{{ route('settings.shipping.save') }}" method="POST" class="editForm column gap-2" enctype="multipart/form-data">
            @csrf
            <div class="name column gap-1">
                <label for="name" required>Full name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $settings['name']) }}">
            </div>
            <div class="address column gap-1">
                <label for="address" required>Shipping Address</label>
                <input type="text" name="address" id="address" value="{{ old('address', $settings['address']) }}">
            </div>
            <div class="country column gap-1">
                <label for="country" required>Country</label>
                <input type="text" name="country" id="country" value="{{ old('country', $settings['country']) }}">
            </div>
            <div class="city column gap-1">
                <label for="city" required>City</label>
                <input type="text" name="city" id="city" value="{{ old('city', $settings['city']) }}">
            </div>
            <div class="zip-code column gap-1">
                <label for="zip-code" required>Zip or postal code</label>
                <input type="text" name="zip-code" id="zip-code" value="{{ old('zip-code', $settings['zip-code']) }}">
            </div>
            <div class="phone column gap-1">
                <label for="phone">Phone number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $settings['phone']) }}">
            </div>
            <div class="email column gap-1">
                <label for="email" required>Email</label>
                <input type="text" name="email" id="email" value="{{ old('email', $settings['email']) }}">
            </div>
            <button class="submit-button" type="submit">Save</button>
        </form>
        <form action="{{ route('settings.shipping.reset') }}" method="POST" class="editForm">
            <button class="submit-button reset" type="submit">Reset</button>
        </form>
    </div>
</div>
@endsection