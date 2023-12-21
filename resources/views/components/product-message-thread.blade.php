<div @class(['product-message-thread', 'thread-active' => $isActive]) data-message-thread-id="{{$messageThread->id}}">
    <img class="profile-image" aria-label="profile-image" src="{{$soldBy->profile_image_path !== null ? '/storage/'.$soldBy->profile_image_path :  '/defaultProfileImage.png'}}" alt="profile-image">
    <div class="product-message-thread-details">
        <div  class="username">{{$soldBy->username}}</div>
        <p class="content">{{$latestMessage->sent_date->diffForHumans(null,true)}} <span>&#183;</span>
        @if($latestMessage->message_type === 'text')
        {{$latestMessage->text_content}}
        @else
        Bargain message
        @endif
        </p>
    </div>
    <a href="/products/{{$product->id}}" class="product-image-link column">
    <img class="product-image" aria-label="product-image" src="{{$product->image_paths[0]}}" alt="product-image">
    </a>
</div>