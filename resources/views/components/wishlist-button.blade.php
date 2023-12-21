@if ($inwishlist)
<div class="wishlist_button" data-inWishlist="true" data-productId="{{$product->id}}">
    <ion-icon name="heart" aria-label="heart-icon"></ion-icon>
    @else
    <div class="wishlist_button" data-inWishlist="false" data-productId="{{$product->id}}">
        <ion-icon name="heart-outline" aria-label="heart-button"></ion-icon>
        @endif
</div>