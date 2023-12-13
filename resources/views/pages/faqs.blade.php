@extends('layouts.app', ['search_bar' => true])

@section('content')
<div class="faqs-wrapper">
    <div class="faqs-page">
        <h1 class="title">FAQ's</h1>
        <div class="questions-wrapper">     
            <div class="question-category">
                <h2>Orders</h2>
                    <div class="question-box">
                        <button class="question">How can I contact you?</button>
                        <div class="answer">
                            <p>You can contact us by sending an <a href="mailto:revogue021@gmail.com">email</a></p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection