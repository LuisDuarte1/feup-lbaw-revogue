@extends('layouts.admin')
@section('content')


@php
$states = ['active' => 'Active', 'needsConfirmation' => 'Needs Confirmation', 'banned'=>'Banned'];
@endphp

<section class="users column justify-center gap-1">
  <div class="admin-wrapper">
    <div class="users-title">
      <h2>Users</h2>
    </div>
    <div class="users-table">
      <table id="users-table">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Photo</th>
            <th scope="col">Name</th>
            <th scope="col">Handle</th>
            <th scope="col">Status</th>
            <th scope="col">Created</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
          <tr>
            <td scope="row" class="user-id">{{ $user->id }}</td>
            <td><img src="{{isset($user->profile_photo_path) ? $user->profile_photo_path : '/defaultProfileImage.png'}}" class="profile-pic" alt="Profile Picture"></td>
            <td>{{$user->display_name}}</td>
            <td>{{$user->username}}</td>
            <td>
              <form method="POST" action="{{route('admin.users.update')}}">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <select name="status" id="account_status">
                  @foreach ($states as $key => $state)
                  <option value="{{$key}}" {{$user->account_status == $key ? 'selected' : '' }}>{{$state}}</option>
                  @endforeach
                </select>
              </form>
            </td>
            <td> {{$user->creation_date}} </td>
            <td>
              <form action="#" method='POST'>
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <button type="submit" formaction="{{ route('admin.users.delete') }}" title="Remove user"><ion-icon name="close-circle-outline"></ion-icon></button>
                <button type="submit" formaction="{{ route('admin.users.block') }}" title="Ban user"><ion-icon name="ban-outline"></ion-icon></button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  {{ $users->links('vendor.pagination.simple-default') }}
</section>
@endsection