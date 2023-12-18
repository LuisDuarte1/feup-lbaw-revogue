@php
$ratingRounded = round($rating * 2) / 2;
$ratingInt = floor($rating);
$ratingHalf = $ratingRounded - $ratingInt;
@endphp

@for ($i = 0; $i < $ratingInt; $i++)
    <ion-icon name="star"></ion-icon>
@endfor
@if ($ratingHalf > 0)
    <ion-icon name="star-half"></ion-icon>
@endif
@for ($i = 0; $i < 5 - round($ratingRounded); $i++)
    <ion-icon name="star-outline"></ion-icon>
@endfor
