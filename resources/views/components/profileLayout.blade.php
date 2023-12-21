<div class="profile-layout">
    <div class="profile-picture-container">
        <img src="{{ $profilePicture }}" alt="profile picture">
    </div>
    <div class="profile-description">
        <div class="profile-description-top column">
            <div class="profile-user">
                <div class="profile-name">
                    <h1>{{ $name }}</h1>
                </div>
                <div class="row items-center gap-1">
                    <div class="profile-username">
                        <h2> {{'@' . $username }}</h2>
                    </div>
                    @if ($id !== 'me')
                    <div class="report row items-center" data-type="user" data-id="{{$id}}">
                        <ion-icon name="flag-outline"></ion-icon>
                        Report
                    </div>
                    @endif
                </div>
            </div>
            <div class="rating">
                <x-reviewStars :rating="$rating" />
                <a href="/profile/{{ $id }}/reviews">({{ round($rating,1) }})</a>
            </div>
        </div>
        <div class="profile-description-bottom">
            <div class="profile-bio">
                <p>{{ $bio }}</p>
            </div>
        </div>
    </div>
</div>