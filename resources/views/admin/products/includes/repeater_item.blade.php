@php
    $child = $child ?? null;

    $imageUrls = [];
    if ($child && $child->images && $child->images->count()) {
        $imageUrls = $child->images
            ->pluck('image')
            ->map(function ($imagePath) {
                return asset($imagePath);
            })
            ->toArray();
    }
@endphp
<div data-repeater-item class="row g-3 align-items-end mb-3">

    {{-- Hidden ID --}}
    @include('admin.layouts.forms.hiddens.id', [
        'id' => $child?->id,
        'name' => 'children[][id]',
    ])


    {{-- Size Select --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        @include('admin.layouts.forms.fields.select', [
            'select_name' => 'children[][color_id]',
            'select_function' => $colors,
            'select_value' => old('color_id', $child?->color_id),
            'label' => __('site.color'),
            'label_req' => true,
            'select2' => true,
        ])
    </div>


    {{-- Colors Select Multiple --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        @include('admin.layouts.forms.fields.multi_select', [
            'select_name' => 'children[][sizes][]',
            'select_function' => $sizes,
            'select_value' => old('sizes', isset($child) ? $child->sizes->pluck('id')->toArray() : []),
            'is_multiple' => true,
            'label' => __('site.sizes'),
            'select_class' => 'select2',
            'select2' => true,
            'label_req' => true,
        ])

    </div>
    {{-- Price --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        @include('admin.layouts.forms.fields.number', [
            'number_name' => 'children[][price]',
            'min' => 0,
            'placeholder' => __('site.price'),
            'label' => __('site.price'),
            'number_value' => $child?->price,
            'label_req' => true,
        ])
    </div>

    {{-- Is Offer --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        @include('admin.layouts.forms.fields.select', [
            'select_name' => 'children[][is_offer]',
            'select_function' => booleantype(),
            'select_value' => $child?->is_offer,
            'label' => __('site.is_offer'),
            'select_id' => 'is_offer',
            'label_req' => true,
        ])
    </div>

    {{-- Offer Price --}}
    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
        @include('admin.layouts.forms.fields.number', [
            'number_name' => 'children[][offer_price]',
            'min' => 0,
            'placeholder' => __('site.offer_price'),
            'label' => __('site.offer_price'),
            'number_value' => $child?->offer_price,
            'not_req' => true,
        ])
    </div>

    {{-- File Upload --}}

    @if (isset($child))
        @include('admin.layouts.forms.fields.multi_dropzone', [
            'name' => 'children[][images]',
            'existing_images' => $imageUrls ?? [],
        ])
    @else
        @include('admin.layouts.forms.fields.multi_dropzone', [
            'name' => 'children[][images]',
        ])
    @endif
   

    {{-- Delete Button --}}
    <div class="col-auto d-flex align-items-end">
        <button class="btn btn-danger mt-2" data-repeater-delete type="button">
            {{ __('site.delete') }}
        </button>
    </div>

</div>
