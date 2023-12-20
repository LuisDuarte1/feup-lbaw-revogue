@extends('layouts.app')

@section('content')
<x-settingsNavbar :tab="$tab" />
<div class="page-center">
    <div class="settings-wrapper column gap-2">
        <h1 class="title">General Settings</h1>
        <div class="column gap-2">
            <h3>Change Password</h3>
            <form action="{{ route('settings.general.reset') }}" class="editForm column gap-3" method="POST">
                @csrf
                <div class="settings-details column gap-2">

                    <div class="old-password column gap-1">
                        <label for="oldPasswordInput" class="form-label">Old Password</label>
                        <input name="old_password" type="password" class="form-control" id="oldPasswordInput" placeholder="Old Password">

                    </div>
                    <div class="new-password column gap-1">
                        <label for="newPasswordInput" class="form-label">New Password</label>
                        <input name="new_password" type="password" class="form-control" id="newPasswordInput" placeholder="New Password">

                    </div>
                    <div class="confirm-new-password column gap-1">
                        <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                        <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput" placeholder="Confirm New Password">
                    </div>
                </div>
                <button type="submit">Save</button>
            </form>
        </div>

        <div class="column gap-2">
            <h3>{{ __('Delete Account') }}</h3>
            <form method="POST" action="{{ route('settings.general.delete') }}" class="editForm column gap-2">
                <div class="column gap-1">
                    @csrf
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                </div>
                <button type="submit">Delete Account</button>
            </form>
        </div>
    </div>
</div>
@endsection