<div class="form-group mb-4">
    <label class="form-label text-muted opacity-75 fw-medium">
        {{ __('site.image') }}
    </label>

    <div class="dropzone needsclick dz-clickable my-dropzone-area" 
         data-existing-images='@json($existing_images ?? [])' {{-- يحتوي على مسارات الصور القديمة --}}
         data-name="{{ $name }}"> {{-- لحفظ اسم الحقل --}}
        <div class="dz-message needsclick">
            {{ __('site.Drag_file_here_to_upload') }}
        </div>
    </div>
    
    <input type="file" name="{{ $name }}[]" class="d-none dropzone-hidden-input" multiple />


    <input type="hidden" name="existing_images_to_keep[]" class="d-none existing-images-input" />
    
    @error($name)
    <span class="text-danger d-block mt-2">{{ $message }}</span>
    @enderror
</div>