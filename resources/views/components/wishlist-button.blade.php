@if ($inwishlist)
<div class="wishlist_button" data-inWishlist="true" data-productId="{{$product->id}}">
    <ion-icon name="heart"></ion-icon>
    @else
    <div class="wishlist_button" data-inWishlist="false" data-productId="{{$product->id}}">
        <ion-icon name="heart-outline"></ion-icon>
        @endif
</div>