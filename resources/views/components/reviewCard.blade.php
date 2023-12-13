<div class="review-card">
    <div class="review-card-header">
        <div class="review-card-wrapper">
            <div class="review-card-info">
                <div class="review-card-name">
                    <div class="review-card-displayName">
                        {{ $reviewerName }}
                    </div>
                    <div class="review-card-username">
                        {{ '@' . $reviewerUsername }}
                    </div> 
                </div>
                <div class="review-card-date">
                    {{ $reviewDate }}
                </div>  
            </div>
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
                <img class="expandable-image" src="{{ $reviewImagePath }}" alt="review image">
            </div>
        @endforeach
    </div>
</div>
