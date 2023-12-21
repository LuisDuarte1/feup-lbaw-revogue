@php
$id = $purchase;
$total = 0;
$purchaseModel = App\Models\Purchase::where('id', $purchase)->get()->first();
$date = $purchaseModel->creation_date->format('d/m/Y');
foreach ($orders as $order) {
foreach ($order->products as $product) {
$total = $total + $product->price - $product->pivot->discount;
}
}
@endphp
<div class="purchase column gap-1">
    <div class="purchase-header row items-center">
        <div class="row">
            <div class="column">
                <h3 class="purchase-title">Purchase #{{$id}}</h3>
                <div class="purchase-date">{{$date}}</div>
            </div>
        </div>
        <div class="purchase-price">Total: {{$total}}€</div>
    </div>
    <div class="purchase-orders column gap-2">
        @foreach ($orders as $order)
        @php
        $seller = $order->products[0]->soldBy;
        $userPicture = $seller->profile_image_path !== null ? "/storage/".$user->profile_image_path : '/defaultProfileImage.png';
        $status = $order->status;
        @endphp
        <div class="purchase-order column gap-3">
            <div class="order-header row gap-1">
                <div class="row items-center gap-3">
                    <div class="row items-center">
                        <img src="{{$userPicture}}" class="profile-picture">
                        <div class="order-user">
                            <a href="/profile/{{$seller->id}}" class="profile-link">
                                <div class="display-name">{{$seller->display_name}}</div>
                                <div class="username">{{'@' . $seller->username}}</div>
                            </a>
                        </div>
                    </div>
                    <div class="order-status row items-center">
                        @php
                        $stat = ucfirst($status);
                        $stat = preg_split('/(?=[A-Z])/', $stat);
                        $stat = implode(" ", $stat);
                        @endphp

                        <ion-icon name="ellipse" class="{{$status}}" aria-label="order-status-icon"></ion-icon>
                        Status: {{$stat}}
                    </div>
                    <div class="order-shipping">
                        Shipping: 2€
                    </div>
                </div>
                <div class="row gap-1 items-center">
                    @if ($status === 'received' && $order->reviewedOrder === null)
                    <a href="/orders/{{$order->id}}/review/new" class="review-button">
                        <button>Review</button>
                    </a>
                    @endif
                    @if ($status === 'pendingShipment')
                    <div class="cancel-button">
                        <button>Cancel</button>
                    </div>
                    @endif
                </div>
            </div>
            <div class="order-products column gap-1">
                @foreach ($order->products as $product)
                @php
                $productPicture = $product->image_paths[0];
                $productName = $product->name;
                $size = $product->attributes()->where('key', 'Size')->get()->first()->value;
                $price = $product->price;
                $discount = $product->pivot->discount;
                @endphp
                <a href="/products/{{$product->id}}" class="order-product row gap-1 items-center">
                    <div class="product-image column items-center">
                        <img src="{{$productPicture}}">
                    </div>
                    <div class="product-info row gap-1 items-center">
                        <div class="column wrapper">
                            <div class="product-name">{{$productName}}</div>
                            <div class="product-size">Size: {{$size}}</div>
                            <div class="product-condition">Condition: Good</div>
                        </div>
                        <div class="column wrapper">
                            <div class="product-total">Total: {{$price - $discount}}€</div>
                            <div class="product-price">Price: {{$price}}€</div>
                            <div class="product-discount">Discount: {{$discount}}€</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>