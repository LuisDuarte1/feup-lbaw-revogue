@php
$reviewDescription = $review->description;
$reviewer = $review->reviewer()->get()->first();
$reviewerRating = $review->stars;
$reviewImagePaths = $review->image_paths;
$reviewDate = $review->sent_date->format('d/m/Y');
$order = $review->reviewedOrder()->get()->first();
@endphp
<div class="review-card">
    <div class="review-card-header">
        <div class="review-card-wrapper">
            <div class="review-card-info">
                <div class="review-card-name">
                    <div class="review-card-displayName">
                        <a href="/profile/{{$reviewer->id}}"> {{ $reviewer->display_name }} </a>
                    </div>
                    <div class="review-card-username">
                        <a href="/profile/{{$reviewer->id}}"> {{ '@' . $reviewer->username }} </a>
                    </div>
                </div>
                <div class="review-card-date">
                    {{ $reviewDate }}
                </div>
            </div>
            @auth   
                @if ($reviewer->id === Auth::user()->id)
                <div class="row">
                    <a href="/orders/{{$order->id}}/review/edit" class="review-card-edit">
                        <ion-icon name="create-outline"></ion-icon>
                    </a>
                    <form class="review-card-delete" action="/orders/{{$order->id}}/review/delete" method="POST">
                        @csrf
                        <button type="submit" class="delete-review">
                            <ion-icon name="trash-outline"></ion-icon>
                        </button>
                    </form>
                </div>
                @endif
            @endauth

        </div>
        <div class="review-card-rating">
            <x-reviewStars :rating="$reviewerRating" />
        </div>
    </div>
    <div class="review-card-description">
        {{ $reviewDescription }}
    </div>
    <div class="review-photos">
        @foreach ($reviewImagePaths as $reviewImagePath)
        <div class="review-photo">
            <img class="expandable-image" loading="lazy" src="{{ $reviewImagePath  }}" alt="review image">
        </div>
        @endforeach
    </div>
</div>