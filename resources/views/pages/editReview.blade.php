@extends('layouts.app')

@section('content')

<section class="edit-review-page column gap-3 justify-center">
    <h1 class="title">Edit Review</h1>

    <form action="/orders/{{$order->id}}/review/edit" class="edit-review-form column gap-1" method="POST" class="reviewForm" enctype="multipart/form-data">
        <h2 required> Rating </h2>
        <div class="row">
            <div class="rating-stars">
                @for ($i = 5; $i > 0; $i--)
                @if ($i == $review->stars)
                <input type="radio" id="{{$i}}-star" name="rating" value="{{$i}}" checked/>
                @else
                <input type="radio" id="{{$i}}-star" name="rating" value="{{$i}}"/>
                @endif
                <label for="{{$i}}-star">
                    <ion-icon name="star" aria-label="star-icon"></ion-icon>
                </label>
                @endfor
            </div>
        </div>
        <h2> Description </h2>
        <textarea name="description" id="edit-description" cols="30" rows="7">{{ $review->description }}</textarea>
        <x-productPhotos :imagePaths="$review->image_paths" />
        <button type="submit">Submit</button>
    </form>
</section>


@endsection