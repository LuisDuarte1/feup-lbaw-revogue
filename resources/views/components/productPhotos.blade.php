<div class="photo-wrapper">
    <h2> Photos </h2>
    <p> Add up to 8 photos in JPG or PNG format. </p>
    <div class="upload-photos">
        @if (count($imagePaths) > 0)
        @foreach ($imagePaths as $imagePath)
        <div class="add-photo existing-photos">
            <img src="{{ $imagePath }}" alt="product photo">
        </div>
        @endforeach
        @endif
        @for ($i = 0; $i < 8 - count($imagePaths); $i++) @if ($i===0) <div class="add-photo">
            <input type="file" id="product-photos" name="imageToUpload[]" accept="image/png, image/jpeg, image/jpg" multiple>
            <label for="product-photos" class="product-photos">
                <ion-icon name="camera" aria-label="add-photos-icon"></ion-icon>
                Add photos
            </label>
    </div>
    @else
    <div class="add-photo"></div>
    @endif
    @endfor
</div>
</div>