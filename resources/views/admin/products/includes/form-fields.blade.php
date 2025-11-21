@include('admin.layouts.forms.head', [
    'show_name' => true,
    'show_content' => true,
    'show_image' => true,
    'name_ar' => $product?->nameLang('ar') ?? old('name.ar'),
    'name_en' => $product?->nameLang('en') ?? old('name.en'),
    'content_ar' => $product?->contentLang('ar') ?? old('content.ar'),
    'content_en' => $product?->contentLang('en') ?? old('content.en'),
])
<div class="row">

    <div class="col-md-6">
        @include('admin.layouts.forms.fields.select', [
            'select_name' => 'unit_id',
            'select_function' => $units,
            'select_value' => $product->unit_id ?? old('unit_id'),
            'select_class' => 'select2',
            'select2' => true,
        ])
    </div>
    <div class="col-md-6">
        @include('admin.layouts.forms.fields.multi_select', [
            'select_name' => 'categories',
            'select_function' => $categories,
            'select_value' => old(
                'categories',
                isset($product) ? $product->categories->pluck('id')->toArray() : []),
            'label_req' => true,
            'label' => __('site.categories'),
        
            'is_multiple' => true,
            'select_class' => 'select2',
            'select2' => true,
        ])
    </div>



</div>


<div class="row">

    <div class="col-md-6">
        @include('admin.layouts.forms.fields.select', [
            'select_name' => 'brand_id',
            'select_function' => $brands,
            'select_value' => $product->brand_id ?? old('brand_id'),
            'select_class' => 'select2',
            'select2' => true,
            'not_req' => true,
        ])
    </div>

    <div class="col-md-6">
        @include('admin.layouts.forms.fields.number', [
            'number_name' => 'max_order',
            'number_id' => 'max_order',
            'min' => 0,
            'placeholder' => __('site.max_order'),
            'number_value' => $product->max_order ?? old('max_order'),
            'label_req' => true,
        ])
    </div>



</div>


@include('admin.products.includes.booliens_fields')

@include('admin.products.includes.price_fields')


 @include('admin.layouts.forms.fields.dropzone', [
        "name" => "image",
        'existingImageUrl' => isset($product) && $product->image ? asset($product->image) : null,
    ])






<div class="form-repeater">
    <div data-repeater-list="children">
        @if (isset($product) && $product->children()->count() > 0)

            @foreach ($product->children as $child)
                @include('admin.products.includes.repeater_item', ['child' => $child])
            @endforeach
        @else
            @include('admin.products.includes.repeater_item', ['child' => null])

        @endif

    </div>

    <button data-repeater-create type="button" class="btn btn-primary mt-3">
        {{ __('site.add') }}
    </button>
</div>


@include('admin.layouts.forms.footer')
@include('admin.layouts.forms.close')
</div>
