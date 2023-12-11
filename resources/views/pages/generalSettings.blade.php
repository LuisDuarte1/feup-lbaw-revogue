@extends('layouts.app')

@section('content')
    <x-settingsNavbar :tab="$tab" />
    <header>
        <h1 class="title settings-title">General Settings</h1>
    </header>
    <div class="edit-settings-page">
        <div class="card">
            <header class="settings-title">{{ __('Change Password') }}</header>

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
                        <input name="old_password" type="password"
                            class="form-control @error('old_password') is-invalid @enderror" id="oldPasswordInput"
                            placeholder="Old Password">
                        @error('old_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="new-password">
                        <label for="newPasswordInput" class="form-label">New Password</label>
                        <input name="new_password" type="password"
                            class="form-control @error('new_password') is-invalid @enderror" id="newPasswordInput"
                            placeholder="New Password">
                        @error('new_password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
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

        <div class="card">
            <header class="settings-title">{{ __('Delete Account') }}</header>
            <form method="POST" action="{{ route('settings.general.delete') }}" accept-charset="UTF-8"
                style="display:inline">
                @csrf
                <button class="btn btn-xs btn-danger delete-user" type="button">
                    <i class="glyphicon glyphicon-trash"></i> Delete Account
                </button>
            </form>

        </div>

    </div>
@endsection
