@php
$ratingRounded = round($rating * 2) / 2;
$ratingInt = floor($rating);
$ratingHalf = $ratingRounded - $ratingInt;
@endphp

@for ($i = 0; $i < $ratingInt; $i++)
    <ion-icon name="star" aria-label="star-icon"></ion-icon>
@endfor
@if ($ratingHalf > 0)
    <ion-icon name="star-half" aria-label="half-star-icon"></ion-icon>
@endif
@for ($i = 0; $i < 5 - round($ratingRounded); $i++)
    <ion-icon name="star-outline" aria-label="star-outline-label"></ion-icon>
@endfor
