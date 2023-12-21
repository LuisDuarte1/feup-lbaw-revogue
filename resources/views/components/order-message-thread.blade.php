<div @class(['order-message-thread', 'thread-active' => $isActive]) data-message-thread-id="{{$messageThread->id}}">
    <img class="profile-image" src="{{$soldBy->profile_image_path !== null ? '/storage/'.$soldBy->profile_image_path :  '/defaultProfileImage.png'}}">
    <div class="product-message-thread-details">
        <div  class="username">{{$soldBy->username}}</div>
        @if(isset($latestMessage))
        <p class="content">{{$latestMessage->sent_date->diffForHumans(null,true)}} <span>&#183;</span>
            @if($latestMessage->message_type === 'text')
            {{$latestMessage->text_content}}
            @elseif($latestMessage->message_type === 'system')
            System message
            @elseif($latestMessage->message_type === 'cancellation')
            Cancellation message
            @endif
        @else
            <p class="content"> No messages yet... </p>
        @endif
        </p>
    </div>
</div>