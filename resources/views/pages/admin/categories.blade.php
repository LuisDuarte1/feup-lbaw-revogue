@extends('layouts.admin')


@section('content')
<section class="admin-categories-page column gap-2">
    <div class="column gap-1 self-center">
        <h3>Add attribute</h3>
        <form action="/admin/categories/add" method="POST" class="admin-attribute-add row gap-2 items-center">
            @csrf
            <input placeholder="Category name" type="text" required name="name">
            <select name="parent_category">
                <option value="">None</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            <button type="submit">Create</button>
        </form>
    </div>
    <div class="admin-table-wrapper">
        <table id="categories-table" class="admin-table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Parent</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($categories as $category)
            <tr>
              <td scope="row" class="user-id">{{ $category->id }}</td>
              <td>{{$category->name}}</td>
              <td>{{$category->parent_category !== null ? $category->parentCategory->name : 'None'}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>

</section>
@endsection