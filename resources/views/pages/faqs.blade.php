@extends('layouts.app', ['search_bar' => true])

@section('content')
<div class="faqs-wrapper">
    <div class="faqs-page">
        <h1 class="title">FAQ's</h1>
        <div class="questions-wrapper">     
            <div class="question-category">
                <h2>Orders</h2>
                <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
            </div>
        </div>
    </div>
</div>

@endsection