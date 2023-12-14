@extends('layouts.app')

@section('content')

<section class="add-review-page column gap-3 justify-center">
    <h1 class="title">Add Review</h1>

    <form class="add-review-form column gap-1" method="POST" class="reviewForm" enctype="multipart/form-data">
        <h2> Rating </h2>
        <div class="row">
            <div class="rating-stars">
                @for ($i = 5; $i > 0; $i--)
                <input type="radio" id="star-{{$i}}" name="rating" />
                <label for="star-{{$i}}">
                    <ion-icon name="star"></ion-icon>
                </label>
                @endfor
            </div>
        </div>
        <h2> Description </h2>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <x-productPhotos :imagePaths=[] />
    </form>
</section>

@endsection