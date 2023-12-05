@extends('layouts.app')


@section('content')
    <div class="edit-settings-page">
        <h1 class="title"> Edit settings </h1>
        <form action="/settings" method="POST" class="editForm" enctype="multipart/form-data">
            <div class="name">
                <label for="name" required>Title</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="price">
                <label for="price" required>Price</label>
                <input type="text" name="price" id="price">
            </div>
            <div class="">
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
@endsection
