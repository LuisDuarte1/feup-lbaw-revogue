@php
    $orderStatus = [
        'pendingShipment' => 'Pending Shipment',
        'shipped' => 'Shipped',
        'received' => 'Received',
        'cancelled' => 'Cancelled'
    ]
@endphp
<div class="changed-order-state column items-center">
    <p><a href="/profile/{{$byUser->id}}">{{$byUser->display_name}}</a> changed Order Status from {{$orderStatus[$fromState]}} to {{$orderStatus[$toState]}}</p>
</div>