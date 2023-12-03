<div class="photo-wrapper">
    <h2> Photos </h2>
    <p> Add up to 8 photos in JPG or PNG format. </p>
    <div class="upload-photos">
        @forelse ($imagePaths as $imagePath)
            <div class="add-photo" id="existing-photos">
                <img src="{{ $imagePath }}" alt="product photo">
            </div>
        @empty
            @for ($i = 0; $i < 8; $i++)
                @if ($i === 0)
                    <div class="add-photo">
                        <input type="file" id="product-photos" name="imageToUpload[]" accept="image/png, image/jpeg, image/jpg" multiple>
                        <label for="product-photos" class="product-photos">
                            <ion-icon name="camera"></ion-icon>
                            Add photos
                        </label>
                    </div>
                @else
                    <div class="add-photo"></div>

                @endif
            @endfor
        @endforelse
        @if (count($imagePaths) > 0)
            @for ($i = 0; $i < 8 - count($imagePaths); $i++)
                @if ($i === 0)
                    <div class="add-photo">
                        <input type="file" id="product-photos" name="imageToUpload[]" accept="image/png, image/jpeg, image/jpg" multiple>
                        <label for="product-photos" class="product-photos">
                            <ion-icon name="camera"></ion-icon>
                            Add photos
                        </label>
                    </div>
                @else
                    <div class="add-photo"></div>
                @endif
            @endfor
        @endif
    </div>
</div>