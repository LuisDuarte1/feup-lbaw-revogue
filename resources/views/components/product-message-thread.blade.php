<div @class(['product-message-thread', 'thread-active' => $isActive]) data-message-thread-id="{{$messageThread->id}}">
    <img class="profile-image" src="{{$soldBy->profile_image_path !== null ? '/storage/'.$soldBy->profile_image_path :  '/defaultProfileImage.png'}}">
    <div class="product-message-thread-details">
        <div  class="username">{{$soldBy->username}}</div>
        <p class="content">{{$latestMessage->sent_date->diffForHumans(null,true)}} <span>&#183;</span> {{$latestMessage->text_content}}</p>
    </div>
    <img class="product-image" src="{{$product->image_paths[0]}}">
</div>