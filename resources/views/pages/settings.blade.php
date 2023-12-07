@extends('layouts.app')


@section('content')
    <x-settingsNav />
    <div class="edit-settings-page">
        <h1 class="title"> Edit settings </h1>
        <form action="/settings/payment" method="POST" class="editForm" enctype="multipart/form-data">
            @php
                foreach ($settings as $key => $value) {
                    if ($key == 'company_name') {
                        $company_name = $value;
                    }
                    if ($key == 'company_address') {
                        $company_address = $value;
                    }
                }
            @endphp
            <div class="name">
                <label for="name" required>Title</label>
                <input type="text" name="company_name" id="company_name" value={{ $company_name }}>
            </div>
            <div class="price">
                <label for="price" required>Price</label>
                <input type="text" name="company_address" id="company_address" value={{ $company_address }}>
            </div>
            <button type="submit">Save</button>
        </form>
    </div>
@endsection
