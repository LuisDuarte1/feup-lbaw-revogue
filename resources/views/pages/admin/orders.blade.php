@extends('layouts.admin')

@section('content')

@php
$states = [
'pendingPayment' => 'Pending Payment',
'requestCancellation' => 'Request Cancellation',
'cancelled' => 'Cancelled',
'pendingShipment' => 'Pending Shipment',
'shipped' => 'Shipped',
'received' => 'Received',
];
@endphp

<section class="users column justify-center gap-3">
    <div class="admin-wrapper">
        <div class="table-title">
            <h2>Orders</h2>
        </div>
        <div class="admin-table column">
            <table id="orders-table" class="admin-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Vender</th>
                        <th scope="col">Buyer</th>
                        <th scope="col">Order Status</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Payment Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                    <tr>
                        <td scope="row">{{ $order->id }}</td>
                        <td>{{ $order->products[0]->soldBy->username }}</td>
                        <td>{{$order->user->username}}</td>
                        <td>
                            <form method="POST" action="{{route('admin.orders.update')}}">
                                @csrf
                                <input name="id" type="hidden" value="{{$order->id}}">
                                <select id="order_status" name="order_status">
                                    @foreach ($states as $key => $state)
                                    <option value="{{ $key }}" {{ $order->status === $key ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td>{{$order->creation_date}}</td>
                        <td>Payment on Delivery</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $orders->links('vendor.pagination.simple-default') }}
</section>

@endsection