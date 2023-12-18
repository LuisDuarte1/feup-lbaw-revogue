@extends('layouts.app')

@section('content')
    <x-settingsNavbar :tab="$tab" />
    <header>
        <h1 class="title settings-title">General Settings</h1>
    </header>
    <div class="edit-settings-page">
        <div class="settings-wrapper">
            <div class="settings-details column gap-2">
                <header class="title settings-title">{{ __('Change Password') }}</header>

                <form action="{{ route('settings.general.reset') }}" class="editForm" method="POST">
                    @csrf
                    <div class="settings-details column gap-2">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="old-password">
                            <label for="oldPasswordInput" class="form-label">Old Password</label>
                            <input name="old_password" type="password" class="form-control" id="oldPasswordInput"
                                placeholder="Old Password">

                        </div>
                        <div class="new-password">
                            <label for="newPasswordInput" class="form-label">New Password</label>
                            <input name="new_password" type="password" class="form-control" id="newPasswordInput"
                                placeholder="New Password">

                        </div>
                        <div class="confirm-new-password">
                            <label for="confirmNewPasswordInput" class="form-label">Confirm New Password</label>
                            <input name="new_password_confirmation" type="password" class="form-control"
                                id="confirmNewPasswordInput" placeholder="Confirm New Password">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>

            <div class="settings-details column gap-2">
                <header class="title settings-title">{{ __('Delete Account') }}</header>
                <form method="POST" action="{{ route('settings.general.delete') }}" class="editForm">
                    @csrf
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password">
                    <button class="btn btn-xs btn-danger delete-user">
                        <i class="glyphicon glyphicon-trash"></i> Delete Account
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
