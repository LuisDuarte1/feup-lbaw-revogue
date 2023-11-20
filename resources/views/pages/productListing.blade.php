@extends('layouts.app')

@section('content')

<section class="list-item-wrapper">
    <div class="list-item column gap-3">
        <header>
            <h1 class="title">
                List an item
            </h1>
        </header>
        <form action="{{ route('productListing')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="column justify-center gap-3">
                <div class="layout-wrapper">
                    <div class="photo-wrapper">
                        <h2> Photos </h2>
                        <p> Add up to 8 photos in JPG or PNG format. </p>
                        <div class="upload-photos">
                            <div class="add-photo">
                                <input type="file" id="product-photos" name="imageToUpload" multiple>
                                <label for="product-photos" class="product-photos">
                                    <ion-icon name="camera"></ion-icon>
                                    Add photos
                                </label>
                            </div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                            <div class="add-photo"></div>
                        </div>
                    </div>
                    <div class="column justify-evenly">
                    <div class="item name">
                        <label for="title">
                            <h2>Title</h2>
                        </label>
                        <input type="text" id="title" name="title" placeholder="Nike t-shirt">
                    </div>
                    <div class="item description">
                        <label for="description">
                            <h2>Description</h2>
                        </label>
                        <textarea id="description" name="description" rows="4" cols="50" placeholder="Only worn a few times, true to size"></textarea>
                    </div>
                    </div>
                </div>
                <div class="item info category">
                    <h2>Info</h2>
                    <div class="category size">
                        <label for="size">
                            <h3>Size</h3>
                        </label>
                        <select id="size" name="size">
                            <option value="xs">XS</option>
                            <option value="s">S</option>
                            <option value="m">M</option>
                            <option value="l">L</option>
                            <option value="xl">XL</option>
                        </select>
                    </div>
                    <div class="category color">
                        <label for="color">
                            <h3>Color</h3>
                        </label>
                        <select id="color" name="color">
                            <option value="white">White</option>
                            <option value="blue">Blue</option>
                            <option value="black">Black</option>
                            <option value="red">Red</option>
                            <option value="yellow">Yellow</option>
                        </select>
                    </div>
                </div>
                <div class="item price">
                    <label for="price">
                        <h2>Price</h2>
                    </label>
                    <input type="text" id="price" name="price" placeholder="€ 0.00">
                </div>
                <button type="submit">
                    List item
                </button>
            </div>
        </form>
    </div>
</section>
@endsection