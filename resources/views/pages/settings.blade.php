@extends('layouts.app')


@section('content')
    <x-settingsNavbar :tab="$tab" />
    <header>
        <h1 class="title settings-title">Payment Settings</h1>
    </header>
    <div class="edit-settings-page">

        <form action="{{ route('settings.payment.save') }}" method="POST" class="editForm" enctype="multipart/form-data">
            @csrf
            <div class="settings-wrapper column justify-center gap-2">


                <div class="settings-details column gap-2">
                    <div class="bank_name">
                        <label for="bank_name" required>Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value={{ $settings['bank_name'] }}>

                    </div>
                    <div class="bank_account_number">
                        <label for="bank_account_number" required>Bank Account Number</label>
                        <input type="text" name="bank_account_number" id="bank_account_number"
                            value={{ $settings['bank_account_number'] }}>


                    </div>
                    <div class="bank_routing_number">
                        <label for="bank_routing_number" required>Bank Routing Number</label>
                        <input type="text" name="bank_routing_number" id="bank_routing_number"
                            value={{ $settings['bank_routing_number'] }}>

                    </div>
                    <div class="bank_account_type">
                        <label for="bank_account_type" required>Bank Account Type</label>
                        <input type="text" name="bank_account_type" id="bank_account_type"
                            value={{ $settings['bank_account_type'] }}>


                    </div>
                    <div class="bank_account_name">
                        <label for="bank_account_name" required>Bank Account Name</label>
                        <input type="text" name="bank_account_name" id="bank_account_name"
                            value={{ $settings['bank_account_name'] }}>

                    </div>
                    <button class="submit-button"type="submit">Save</button>
        </form>

        <form action="{{ route('settings.payment.reset') }}" method="POST" class="editForm">
            <button class="submit-button reset" type="submit">Reset</button>
        </form>

    </div>
    </div>
@endsection
