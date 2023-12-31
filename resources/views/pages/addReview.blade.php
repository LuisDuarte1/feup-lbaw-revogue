@extends('layouts.app')

@section('content')

<section class="add-review-page column gap-3 justify-center">
    <h1 class="title">Add Review</h1>

    <form action="/orders/{{$order->id}}/review/new" class="add-review-form column gap-1" method="POST" class="reviewForm" enctype="multipart/form-data">
        <h2 required> Rating </h2>
        <div class="row">
            <div class="rating-stars">
                @for ($i = 5; $i > 0; $i--)
                <input type="radio" id="star-{{$i}}" name="rating" value="{{$i}}"/>
                <label for="star-{{$i}}">
                    <ion-icon name="star" aria-label="star-icon"></ion-icon>
                </label>
                @endfor
            </div>
        </div>
        <h2> Description </h2>
        <textarea name="description" id="description" cols="30" rows="7"></textarea>
        <x-productPhotos :imagePaths=[] />
        <button type="submit">Submit</button>
    </form>
</section>

@endsection