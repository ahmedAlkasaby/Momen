@php
    $name= $name ?? 'image';
    $existingImageUrl = $existingImageUrl ?? null;
    // إذا كانت هناك صورة قديمة، اجعل الحقل غير مطلوب لتجنب خطأ الـ validation
    $isRequired = ($existingImageUrl !== null) ? false : ($isRequired ?? true); 
    
    // نستخرج المسار النسبي (بدون asset()) ليتم إرساله للباك إند
    $existingImagePath = null;
    if ($existingImageUrl) {
        // إذا كان $existingImageUrl يحتوي على URL كامل (مثلاً: http://domain.com/storage/path/img.jpg)،
        // تحتاج لاستخراج الجزء النسبي منه الذي تستخدمه في قاعدة البيانات
        $existingImagePath = str_replace(url('/'), '', $existingImageUrl); 
    }
@endphp
<div class="form-group mb-4">
    <label class="form-label text-muted opacity-75 fw-medium" for="formImage">
        {{ __('site.image') }}
    </label>

    <div class="dropzone needsclick dz-clickable dz-max-files-reached @error($name) is-invalid @enderror" 
         id="myDropzoneArea"
         data-existing-image-path="{{ $existingImagePath }}" {{-- المسار النسبي --}}
         data-existing-image-url="{{ $existingImageUrl }}"> {{-- المسار الكامل للعرض --}}
        <div class="dz-message needsclick">
            {{ __('site.Drag_file_here_to_upload') }}
        </div>
    </div>
    
    {{-- 1. حقل الملفات الجديدة (input type="file") --}}
    <input type="file" name="{{ $name }}" id="hiddenImageInput" class="d-none" {{ $isRequired ? 'required' : '' }} />

    {{-- 2. 🔥 حقل إخفاء المسار القديم 🔥 (سنستخدمه لتمرير الصورة القديمة إلى Laravel) --}}
    <input type="hidden" name="existing_{{ $name }}" id="existingImageHiddenInput" value="{{ $existingImagePath }}" />


    @error($name)
        <span class="text-danger d-block mt-2">{{ $message }}</span>
    @enderror
</div>