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
                            <h2><label for="title" required>
                                    Title
                                </label></h2>
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
                                <h3><label for="type" required>
                                        Category
                                    </label></h3>
                                <select id="type" name="category">
                                    <option value=""></option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="category size">
                                <h3><label for="size" required>
                                        Size
                                    </label></h3>
                                <select id="size" name="size">
                                    <option value=""></option>
                                    @foreach ($sizes as $size)
                                    <option value="{{ $size }}">{{ $size}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="category color">
                                <h3><label for="color" required>
                                        Color
                                    </label></h3>
                                <select id="color" name="color">
                                    <option value=""></option>
                                    @foreach ($colors as $color)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item tags">
                    <label for="tags">
                        <h2>Enhance your listing</h2>
                    </label>
                    <input type="text" id="search_tag" name="search_tag" placeholder="">
                    <div class="tags-list">
                    </div>
                    <div class="input-list">
                    </div>
                </div>
                <div class="item price">
                    <h2><label for="price" required>
                            Price
                        </label></h2>
                    <input type="number" id="price" name="price" placeholder="€ 0.00" required>
                </div>
                <button type="submit">
                    List item
                </button>
            </div>
        </form>
    </div>
</section>
@endsection