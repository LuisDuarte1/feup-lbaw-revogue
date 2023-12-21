@extends('layouts.admin')


@section('content')
@php
$states = [
'user' => 'User',
'product' => 'Product',
'message_thread' => 'Message Thread',
];
@endphp

<section class="users column justify-center gap-3">
    <div class="admin-wrapper">
        <div class="users-title">
            <h2>Reports</h2>
        </div>
        <div class="users-table column">
            <table id="users-table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Report Type</th>
                        <th scope="col">Creation Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Closed by</th>
                        <th scope="col">Reporter</th>
                        <th scope="col">Reported</th>
                        <th scope="col">Product</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td scope="row">{{ $report->id }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{$report->creation_date}}</td>
                        <td>
                            bloat
                        </td>
                        <td>{{$report->is_closed}}</td>
                        <td>{{$report->reporter}}</td>
                        <td>{{$report->reported}}</td>
                        <td>{{$report->product}}</td>
                        <td>{{$report->message}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $reports->links('vendor.pagination.simple-default') }}
</section>
@endsection