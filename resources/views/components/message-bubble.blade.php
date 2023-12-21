@php
    $systemMessage = !isset($currentUser);
    $fromSelf = null;
    if(!$systemMessage) {
        $fromSelf = $message->from_user == $currentUser->id;
    }
@endphp

<div @class([
    'message-bubble',
    'sent' => isset($fromSelf) && $fromSelf,
    'received' => isset($fromSelf) &&  !$fromSelf,
    'systemMessage' => $systemMessage,
    'has-element' => $message->image_path !== null || $message->message_type == 'bargain'
    ])>
    @if($message->image_path !== null)
        <img class="message-image expandable-image" src="{{$message->image_path}}" alt="message-image">
    @endif
    @if ($message->message_type == 'text')
    <div class="message-text-content">
        <p>{{$message->text_content}}</p>
    </div>
    @endif
    @if($message->message_type == 'bargain')
    @php
        $bargain = $message->associatedBargain;
        $product = $bargain->getProduct;
    @endphp
    <div class="message-bargain-content" data-bargain-id="{{$bargain->id}}">
        <div class="column items-center w-full">
            <p class="old-price">Old Price: <span>{{$product->price}}€</span></p>
            <p class="new-price">{{$bargain->proposed_price}}€</p>
            <div class="row">
                @if($bargain->bargain_status === 'pending')
                    @if(!$fromSelf)
                        <button class="accept-bargain"><ion-icon name="checkmark-outline"></ion-icon>Accept</button>
                        <button class="reject-bargain"><ion-icon name="close-outline"></ion-icon>Reject</button>
                    @else
                        <button class="cancel-bargain"><ion-icon name="close-outline"></ion-icon>Cancel</button>
                    @endif
                @elseif($bargain->bargain_status === 'rejected')
                        <button class="cancel-bargain rejected" disabled><ion-icon name="close-outline"></ion-icon>Cancelled</button>
                @elseif($bargain->bargain_status === 'accepted')
                    @php
                        $voucher = $bargain->voucher;    
                    @endphp
                    @if($voucher->belongs_to == Auth::user()->id)
                        <p>Voucher: <a href="/cart?voucher={{$voucher->code}}">{{$voucher->code}}</a></p>
                    @else
                        <p>Voucher was given to the other user.</p>
                    @endif
                @endif
            </div>

        </div>
    </div>
    @endif
    @if($message->message_type === 'system')
    <div class="message-system-content">
        {!! $message->system_message !!}
    </div>
    @endif
    @if($message->message_type === 'cancellation')
    @php
        $cancellation = $message->orderCancellation;
    @endphp
    <div class="message-cancellation-content" data-cancellation-id="{{$cancellation->id}}">
        <div class="column items-center w-full">
            <p class="cancellation-text">Cancellation</p>
            <div class="row gap-1">
                @if($cancellation->order_cancellation_status === 'pending')
                    @if(!$fromSelf)
                        <button class="accept-cancellation"><ion-icon name="checkmark-outline"></ion-icon>Accept</button>
                        <button class="reject-cancellation"><ion-icon name="close-outline"></ion-icon>Reject</button>
                    @else
                        <button class="cancel-cancellation"><ion-icon name="close-outline"></ion-icon>Cancel</button>
                    @endif
                @elseif($cancellation->order_cancellation_status  === 'cancelled')
                    <button class="cancel-cancellation rejected" disabled><ion-icon name="close-outline"></ion-icon>Rejected</button>
                @elseif($cancellation->order_cancellation_status  === 'accepted')
                    <p class="order-cancelled">Order cancelled</p>
                @endif
            </div>
        </div>
    </div>
    @endif
    <div class="message-date">{{$message->sent_date->diffForHumans(['parts' => 2])}}</div>
</div>