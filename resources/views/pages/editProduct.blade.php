@extends('layouts.app')


@section('content')
    <div class="edit-product-page">
        <h1 class="title"> Edit product </h1>
        <form action="/products/{{$product->id}}/edit" method="POST" class="editForm">
            <div class="name">
                <label for="name" required>Title</label>
                <input type="text" name="name" id="name" value="{{$product->name}}">
            </div>
            <div class="price">
                <label for="price" required>Price</label>
                <input type="text" name="price" id="price" value="{{$product->price}}">
            </div>
            <div class="description">
                <label for="description" >Description</label>
                <textarea id="description" name="description" cols="40" rows="6">{{$product->description}}</textarea>
            </div>
            <button type="submit">Edit</button>
        </form>
    </div>
@endsection