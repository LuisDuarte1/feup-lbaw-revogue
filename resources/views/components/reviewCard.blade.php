<div class="review-card">
    <div class="review-card-header">
        <div class="review-card-wrapper">
            <div class="profile-picture-container">
                <img src="{{ $reviewerPicture }}" alt="profile picture">
            </div>
            <div class="review-card-name">
                <div class="review-card-displayName">
                    {{ $reviewerName }}
                </div>
                <div class="review-card-username">
                    {{ '@' . $reviewerUsername }}
                </div>
            </div>
        </div>
        <div class="review-card-rating">
            @for ($i = 0; $i < $reviewerRating; $i++)
                <ion-icon name="star"></ion-icon>
            @endfor
            @for ($i = 0; $i < 5 - $reviewerRating; $i++)
                <ion-icon name="star-outline"></ion-icon>
            @endfor
        </div>

    </div>
    <div class="review-card-description">
        {{ $reviewDescription }}
    </div>
</div>
