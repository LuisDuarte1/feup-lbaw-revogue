@extends('layouts.app', ['search_bar' => true])

@section('content')
<div class="faqs-wrapper">
    <div class="faqs-page column page-center gap-1">
        <h1 class="title">FAQ's</h1>
        <div class="questions-wrapper column gap-1">
            <div class="question-category column gap-2">
                <h2>Selling</h2>
                <div class="column gap-2">
                    <div>
                        <x-expandableCard question="I haven't received my payment. What can I do?" answer="All sales made through ReVogue are covered by Seller Protection. Please contact customer support if you haven't received your payment - joseph.waldor@revogue.com" />
                    </div>
                    <div>
                        <x-expandableCard question="How do I transmit to the buyer that the order placed has been shipped" answer="You can change the order status in the 'Order' section of the messages. " />
                    </div>
                    <div>
                        <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
                    </div>
                </div>
                <h2> Buying </h2>
                <div class="column gap-2">
                    <div>
                        <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
                    </div>
                    <div>
                        <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
                    </div>
                    <div>
                        <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection