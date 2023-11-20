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
                <div class="layout-wrapper">
                    <div class="column justify-evenly gap-2">
                        <div class="name">
                            <label for="title">
                                <h2>Title</h2>
                            </label>
                            <input type="text" id="title" name="title" placeholder="Nike t-shirt">
                        </div>
                        <div class="description">
                            <label for="description">
                                <h2>Description</h2>
                            </label>
                            <textarea id="description" name="description" rows="6" cols="40" placeholder="Only worn a few times, true to size"></textarea>
                        </div>
                    </div>

                    <div class="column justify-evenly gap-2 w-full">
                        <div class="info category">
                            <h2>Info</h2>
                            <div class="category type">
                                <label for="type">
                                    <h3>Category</h3>
                                </label>
                                <select id="type" name="type">
                                    <option value=""></option>
                                    <option value="Tops">Tops</option>
                                    <option value="Dresses and Jumpsuits">Dresses and Jumpsuits</option>
                                    <option value="Jeans">Jeans</option>
                                    <option value="Footwear">Footwear</option>
                                    <option value="Accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="category size">
                                <label for="size">
                                    <h3>Size</h3>
                                </label>
                                <select id="size" name="size">
                                    <option value=""></option>
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
                                    <option value=""></option>
                                    <option value="white">White</option>
                                    <option value="blue">Blue</option>
                                    <option value="black">Black</option>
                                    <option value="red">Red</option>
                                    <option value="yellow">Yellow</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item tags">
                    <label for="tags">
                        <h2>Enhance your listing</h2>
                    </label>
                    <input type="text" id="price" name="price" placeholder="">
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