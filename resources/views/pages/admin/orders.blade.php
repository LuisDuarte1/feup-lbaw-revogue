@extends('layouts.admin')

@section('content')

<section class="users column justify-center gap-1">
    <div class="users-title">
        <h2>Orders</h2>
    </div>
    <div class="users-table column">
        <table id="users-table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Vender</th>
                    <th scope="col">Buyer</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Sent Date</th>
                    <th scope="col">Payment Type</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="row class=" id->1</th>
                    <td>Merch NI</td>
                    <td>@MIAEEUP</td>
                    <td>
                        <form method="POST" action=#>
                            <select>
                                <option value="pendingPayment">Pending Payment</option>
                                <option value="requestCancellation">Request Cancellation</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="pendingShipment">Pending Shipment</option>
                                <option value="shipped">Shipped</option>
                                <option value="received">Received</option>
                            </select>
                        </form>
                    </td>
                    <td>12/12/2020</td>
                    <td>Mbway</td>

                </tr>
                <tr>
                    <td scope="row">2</th>
                    <td>Jacob</td>
                    <td>@fat</td>
                    <td>
                        <form method="POST" action=#>
                            <select>
                                <option value="pendingPayment">Pending Payment</option>
                                <option value="requestCancellation">Request Cancellation</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="pendingShipment">Pending Shipment</option>
                                <option value="shipped">Shipped</option>
                                <option value="received">Received</option>
                            </select>
                        </form>
                    </td>
                    <td>12/12/2020</td>
                    <td>Payment on delivery</td>

                </tr>
                <tr>
                    <td scope="row">3</th>
                    <td>Larry the Bird</td>
                    <td>@twitter</td>
                    <td>
                        <form method="POST" action=#>
                            <select>
                                <option value="pendingPayment">Pending Payment</option>
                                <option value="requestCancellation">Request Cancellation</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="pendingShipment">Pending Shipment</option>
                                <option value="shipped">Shipped</option>
                                <option value="received">Received</option>
                            </select>
                        </form>
                    </td>
                    <td>12/12/2020</td>
                    <td>Paypal</td>

                    <td>
                </tr>
            </tbody>
        </table>

        {{ $orders->links('vendor.pagination.simple-default') }}
    </div>
</section>

@endsection