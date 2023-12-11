<div class="profile-layout">
    <div class="profile-picture-container">
        <img src="{{ $profilePicture }}" alt="profile picture">
    </div>
    <div class="profile-description">
        <div class="profile-descriptiom-top">
            <div class="profile-name">
                <h1>{{ $name }}</h1>
            </div>
            <div class="profile-username">
                <h2> {{'@' . $username }}</h2>
            </div>
            <div class="rating">
                @php
                $rating = round($rating * 2) / 2;
                $aux = floor($rating);
                $half = $rating - $aux;
                @endphp
                @for ($i = 0; $i < $aux; $i++)
                    <ion-icon name="star"></ion-icon>
                @endfor
                @if ($half > 0)
                    <ion-icon name="star-half"></ion-icon>
                @endif
                @for ($i = 0; $i < 5 - round($rating); $i++)
                    <ion-icon name="star-outline"></ion-icon>
                @endfor
                
                <a href="/profile/{{ $id }}/reviews">({{ $rating }})</a>
            </div>
        </div>
        <div class="profile-description-bottom">
            <div class="profile-bio">
                <p>{{ $bio }}</p> 
            </div>
        </div>
    </div>
</div>