@extends('layouts.admin')


@section('content')
@php
$status = [
true => 'Closed',
false => 'Open',
];
@endphp

<section class="column justify-center gap-3">
    <div class="admin-wrapper">
        <div class="table-title">
            <h2>Reports</h2>
        </div>
        <div class="admin-table-wrapper">
            <table id="reports-table" class="admin-table">
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
                        <th scope="col">Message Thread</th>
                        <th scope="col" class="report-reason">Reason</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td scope="row">{{ $report->id }}</td>
                        <td>{{ $report->type === 'message_thread' ? 'message thread' : $report->type}}</td>
                        <td>{{$report->creation_date}}</td>
                        <td>
                            <form method="POST" action="{{route('admin.reports.update')}}">
                                @csrf
                                <input name="id" type="hidden" value="{{$report->id}}">
                                <select id="report_status" name="report_status">
                                    @foreach ($status as $key => $state)
                                    <option value="{{ $key }}" {{ $report->is_closed == $key ? 'selected' : '' }}>{{ $state }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        @if ($report->closed_by !== NULL)
                        @php
                        $admin = App\Models\Admin::find($report->closed_by)->email;
                        @endphp

                        <td>{{$admin}}</td>
                        @else
                        <td></td>
                        @endif
                        @php
                        $reporter = App\Models\User::find($report->reporter)->username;
                        $reported = App\Models\User::find($report->reported)->username;
                        @endphp
                        <td>{{$reporter}}</td>
                        <td>{{$reported}}</td>
                        <td>{{$report->product !== NULL ? $report->product : 'Does not apply' }}</td>
                        <td>
                            {{$report->message_thread !== NULL ? $report->message_thread : 'Does not apply'}}
                            @if($report->message_thread !== NULL)
                            <a href="{{route('admin.reports.messages', ['messageThread' => $report->message_thread, 'reporter' => $report->reporter])}}" target="_blank" title="View message thread"><ion-icon name="open-outline"></ion-icon></a>
                            @endif
                        </td>
                        <td>{{$report->reason}}</td>
                        <td>
                            <form action="#" method='POST'>
                                @csrf
                                <input type="hidden" name="id" value="{{$report->id}}">
                                <button type="submit" formaction="{{ route('admin.reports.delete') }}" title="Remove report"><ion-icon name="trash-outline"></ion-icon></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $reports->links('vendor.pagination.simple-default') }}
</section>
@endsection