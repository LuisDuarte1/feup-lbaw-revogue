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
                <div class="profile-username">
                    <h2> {{'@' . $username }}</h2>
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