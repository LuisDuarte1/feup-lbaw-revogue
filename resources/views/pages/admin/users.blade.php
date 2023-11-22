@extends('layouts.admin')


@section('content')

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
          <tr>
            <td scope="row" class="user-id">1</th>
            <td><img src="../defaultProfileImage.png" class="profile-pic" alt="Profile Picture"></td>
            <td>Mark</td>
            <td>@mdo</td>
            <td>
              <form method="POST" action=#>
                <select>
                  <option value="active">active</option>
                  <option value="needsConfirmation">needsConfirmation</option>
                  <option value="banned">banned</option>
                </select>
              </form>
            </td>
            <td> 3 years ago </td>
            <td>
              <form action="#" method='POST'>
                <button type="submit" formaction=""><ion-icon name="close-circle-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="ban-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="bar-chart-outline"></ion-icon></button>
              </form>
            </td>
          </tr>
          <tr>
            <td scope="row" class="user-id">2</th>
            <td><img src="../defaultProfileImage.png" class="profile-pic" alt="Profile Picture"></td>
            <td>Jacob</td>
            <td>@fat</td>
            <td>
              <form method="POST" action=#>
                <select>
                  <option value="active">active</option>
                  <option value="needsConfirmation">needsConfirmation</option>
                  <option value="banned">banned</option>
                </select>
              </form>
            </td>
            <td> 3 years ago </td>
            <td>
              <form action="#" method='POST'>
                <button type="submit" formaction=""><ion-icon name="close-circle-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="ban-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="bar-chart-outline"></ion-icon></button>
              </form>
            </td>
          </tr>
          <tr>
            <td scope="row" class="user-id">3</th>
            <td><img src="../defaultProfileImage.png" class="profile-pic" alt="Profile Picture"></td>
            <td>Larry the Bird</td>
            <td>@twitter</td>
            <td>
              <form method="POST" action=#>
                <select>
                  <option value="active">active</option>
                  <option value="needsConfirmation">needsConfirmation</option>
                  <option value="banned">banned</option>
                </select>
              </form>
            </td>
            <td> 3 years ago </td>
            <td>
              <form action="#" method='POST'>
                <button type="submit" formaction=""><ion-icon name="close-circle-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="ban-outline"></ion-icon></button>
                <button type="submit" formaction=""><ion-icon name="bar-chart-outline"></ion-icon></button>
              </form>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  {{ $users->links('vendor.pagination.simple-default') }}
</section>
@endsection