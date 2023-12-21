@extends('layouts.admin')


@section('content')
<section class="admin-attributes-page column gap-2">
    <div class="column gap-1 self-center">
        <h3>Add attribute</h3>
        <form action="/admin/attributes/add" method="POST" class="admin-attribute-add row gap-2 items-center">
            @csrf
            <input placeholder="Key" type="text" required name="attribute_key">
            <input placeholder="Value" type="text" required name="attribute_value">
            <button type="submit">Create</button>
        </form>
    </div>
    <div class="admin-table-wrapper">
        <table id="attributes-table" class="admin-table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Key</th>
              <th scope="col">Value</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($attributes as $attribute)
            <tr>
              <td scope="row" class="user-id">{{ $attribute->id }}</td>
              <td>{{$attribute->key}}</td>
              <td>{{$attribute->value}}</td>
              <td>
                <form action="#" method='POST'>
                  @csrf
                  <input type="hidden" name="id" value="{{$attribute->id}}">
                  <button type="submit" formaction="/admin/attributes/remove" title="Remove attribute"><ion-icon name="close-circle-outline"></ion-icon></button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    {{ $attributes->links('vendor.pagination.simple-default') }}

</section>
@endsection