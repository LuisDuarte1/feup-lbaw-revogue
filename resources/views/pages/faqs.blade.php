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
                        <x-expandableCard question="How do I transmit to the buyer that the order placed has been shipped" answer="You have the option to update the order status within the 'Order' section of the messages." />
                    </div>
                    <div>
                        <x-expandableCard question="Shipping Guide" answer="Arrange domestic or worldwide shipping (go down to your local post office or purchase a shipping label through a third party)." />
                    </div>
                </div>
                <h2> Buying </h2>
                <div class="column gap-2">
                    <div>
                        <x-expandableCard question="How do I place an order?" answer="You can place an order by clicking on the 'Add to Cart' button on the product page. You can then proceed to checkout and pay for your order." />
                    </div>
                    <div>
                        <x-expandableCard question="I haven't received my item" answer="All purchases made through ReVogue are covered by Buyer Protection. We will ensure you get a full refund, if you don't receive your item. Please contact customer support - joseph.waldor@revogue.com" />
                    </div>
                    <div>
                        <x-expandableCard question="What happens after I make a purchase?" answer="When you buy on ReVogue, we'll send your seller your payment and shipping details, so they can ship your purchase. What happens next? We'll notify your seller in-app and via email with a sales receipt for your purchase. The sales receipt will include the delivery address you used on the transaction. Your seller will organise packaging and shipping for your item. Feel free to contact your seller with a friendly message asking for any updates" />
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection