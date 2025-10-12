<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\FreeShippingRule;
use App\Rules\OfferPercentRule;
use App\Rules\OfferRule;
use App\Rules\OrderMaxRule;
use App\Rules\PriceOfferRule;
use App\Rules\UniqueChildSizeRule;
use App\Rules\ValidServiceCategoriesRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = optional($this->product)->id;

        return [
            'code' => [
                'required',
                'string',
                'max:255',
            ],

            'image' => [
                $productId ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5000',
            ],

            "name.ar" => "required|string|max:255",
            "name.en" => "required|string|max:255",
            "description.ar" => "nullable|string|max:1000",
            "description.en" => "nullable|string|max:1000",


            'price' => ['required', 'numeric', 'gt:1'],

            'offer' => ['required', 'boolean',new OfferRule($this)],
            'offer_percent' => ['nullable', 'numeric', 'min:1'],
            'offer_amount' => ['nullable', 'numeric', 'min:1','max:99'],
            'offer_price' => ['nullable', 'numeric', 'min:1',new PriceOfferRule($this)],

            'free_shipping' => ['required', 'boolean',new FreeShippingRule($this)],
            'shipping_cost' => ['nullable', 'numeric', 'min:0'],

            'amount' => ['required', 'numeric', 'min:1'],
            'max_order' => ['required', 'numeric', 'min:1',new OrderMaxRule($this)],

            'date_start'=>'nullable|date',
            'date_end'=>'nullable|date|after:date_start',

            'service_id'=>'required|exists:services,id',
            'unit_id'=>'required|exists:units,id',
            'brand_id'=>'nullable|exists:brands,id',
            'size_id'=>'nullable|exists:sizes,id',

            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', new ValidServiceCategoriesRule($this->input('service_id'))],

            'order_id'=>'nullable|integer|min:1',

            'children' => ['nullable', 'array',new UniqueChildSizeRule()],
            'children.*.size_id' => ['required', 'exists:sizes,id'],
            'children.*.amount' => ['required', 'numeric', 'min:1'],
            'children.*.offer' => ['required', 'boolean'],
            'children.*.offer_percent' => ['nullable', 'numeric', 'min:1'],
            'children.*.offer_amount' => ['nullable', 'numeric', 'min:1'],
            'children.*.offer_price' => ['nullable', 'numeric', 'min:1'],

        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('children') && is_array($this->children)) {
                foreach ($this->children as $index => $child) {
                    $offer = filter_var($child['offer'] ?? false, FILTER_VALIDATE_BOOLEAN);
                    $hasPercent = !empty($child['offer_percent']);
                    $hasAmount = !empty($child['offer_amount']);
                    $hasPrice = !empty($child['offer_price']);

                    $filled = array_filter([$hasPercent, $hasAmount, $hasPrice]);

                    if ($offer) {
                        if (count($filled) === 0) {
                            $validator->errors()->add("children.$index.offer", __('validation.you_must_select_an_offer'));
                        } elseif (count($filled) > 1) {
                            $validator->errors()->add("children.$index.offer", __('validation.you_must_select_one_offer'));
                        }
                    }
                }

                $maxOrder = $this->input('max_order');

                foreach ($this->children as $index => $child) {
                    if (isset($child['amount']) && isset($maxOrder) && $child['amount'] <= $maxOrder) {
                        $validator->errors()->add("children.$index.amount", __("validation.child_amount_gt_max_order", [
                            'child' => $index + 1,
                            'max_order' => $maxOrder,
                        ]));
                    }
                }
            }



        });
    }


    public function messages()
    {
        return [
            // الاسم
            "name.ar.required" => __("validation.required", ["attribute" => __("site.name")]),
            "name.en.required" => __("validation.required", ["attribute" => __("site.name")]),
            "name.ar.string" => __("validation.string", ["attribute" => __("site.name")]),
            "name.en.string" => __("validation.string", ["attribute" => __("site.name")]),
            "name.ar.max" => __("validation.max.string", ["attribute" => __("site.name"), "max" => 255]),
            "name.en.max" => __("validation.max.string", ["attribute" => __("site.name"), "max" => 255]),

            // الكود
            'code.required' => __("validation.required", ['attribute' => __('site.code')]),
            'code.string' => __("validation.string", ['attribute' => __('site.code')]),
            'code.max' => __("validation.max.string", ['attribute' => __('site.code'), 'max' => 255]),
            'code.unique' => __("validation.unique", ['attribute' => __('site.code')]),

            // الصورة
            'image.required' => __("validation.required", ['attribute' => __('site.image')]),
            'image.image' => __("validation.image", ['attribute' => __('site.image')]),
            'image.mimes' => __("validation.mimes", ['attribute' => __('site.image')]),
            'image.max' => __("validation.max.file", ['attribute' => __('site.image'), 'max' => 5000]),

            // السعر
            'price.required' => __("validation.required", ['attribute' => __('site.price')]),
            'price.numeric' => __("validation.numeric", ['attribute' => __('site.price')]),
            'price.gt' => __("validation.gt.numeric", ['attribute' => __('site.price'), 'value' => 1]),

            // العرض
            'offer.required' => __("validation.required", ['attribute' => __('site.offer')]),
            'offer.boolean' => __("validation.boolean", ['attribute' => __('site.offer')]),
            'offer_percent.numeric' => __("validation.numeric", ['attribute' => __('site.offer_percent')]),
            'offer_percent.min' => __("validation.min.numeric", ['attribute' => __('site.offer_percent'), 'min' => 1]),
            'offer_amount.numeric' => __("validation.numeric", ['attribute' => __('site.offer_amount')]),
            'offer_amount.min' => __("validation.min.numeric", ['attribute' => __('site.offer_amount'), 'min' => 1]),
            'offer_amount.max' => __("validation.max.numeric", ['attribute' => __('site.offer_amount'), 'max' => 99]),
            'offer_price.numeric' => __("validation.numeric", ['attribute' => __('site.offer_price')]),
            'offer_price.min' => __("validation.min.numeric", ['attribute' => __('site.offer_price'), 'min' => 1]),

            // الشحن
            'free_shipping.required' => __("validation.required", ['attribute' => __('site.free_shipping')]),
            'free_shipping.boolean' => __("validation.boolean", ['attribute' => __('site.free_shipping')]),
            'shipping_cost.numeric' => __("validation.numeric", ['attribute' => __('site.shipping_cost')]),
            'shipping_cost.min' => __("validation.min.numeric", ['attribute' => __('site.shipping_cost'), 'min' => 0]),

            // الكمية وحدود الطلب
            'amount.required' => __("validation.required", ['attribute' => __('site.amount')]),
            'amount.numeric' => __("validation.numeric", ['attribute' => __('site.amount')]),
            'amount.min' => __("validation.min.numeric", ['attribute' => __('site.amount'), 'min' => 1]),

            'max_order.required' => __("validation.required", ['attribute' => __('site.max_order')]),
            'max_order.numeric' => __("validation.numeric", ['attribute' => __('site.max_order')]),
            'max_order.min' => __("validation.min.numeric", ['attribute' => __('site.max_order'), 'min' => 1]),

            // التواريخ
            'date_start.date' => __("validation.date", ['attribute' => __('site.date_start')]),
            'date_end.date' => __("validation.date", ['attribute' => __('site.date_end')]),
            'date_end.after' => __("validation.after", ['attribute' => __('site.date_end'), 'date' => __('site.date_start')]),

            // العلاقات الخارجية
            'service_id.required' => __("validation.required", ['attribute' => __('site.service')]),
            'service_id.exists' => __("validation.exists", ['attribute' => __('site.service')]),

            'unit_id.required' => __("validation.required", ['attribute' => __('site.unit')]),
            'unit_id.exists' => __("validation.exists", ['attribute' => __('site.unit')]),

            'brand_id.exists' => __("validation.exists", ['attribute' => __('site.brand')]),
            'size_id.exists' => __("validation.exists", ['attribute' => __('site.size')]),

            'order_id.integer' => __("validation.integer", ['attribute' => __('site.order_id')]),
            'order_id.min' => __("validation.min.numeric", ['attribute' => __('site.order_id'), 'min' => 1]),

            // التصنيفات
            'categories.required' => __("validation.required", ['attribute' => __('site.categories')]),
            'categories.array' => __("validation.array", ['attribute' => __('site.categories')]),
            'categories.*.required' => __("validation.required", ['attribute' => __('site.category')]),
            'categories.*.integer' => __("validation.integer", ['attribute' => __('site.category')]),

            // الأطفال (المنتجات الفرعية)
            'children.array' => __("validation.array", ['attribute' => __('site.children')]),

            'children.*.size_id.required' => __("validation.required", ['attribute' => __('site.child_size')]),
            'children.*.size_id.exists' => __("validation.exists", ['attribute' => __('site.child_size')]),

            'children.*.amount.required' => __("validation.required", ['attribute' => __('site.child_amount')]),
            'children.*.amount.numeric' => __("validation.numeric", ['attribute' => __('site.child_amount')]),
            'children.*.amount.min' => __("validation.min.numeric", ['attribute' => __('site.child_amount'), 'min' => 1]),

            'children.*.offer.required' => __("validation.required", ['attribute' => __('site.child_offer')]),
            'children.*.offer.boolean' => __("validation.boolean", ['attribute' => __('site.child_offer')]),

            'children.*.offer_percent.numeric' => __("validation.numeric", ['attribute' => __('site.child_offer_percent')]),
            'children.*.offer_percent.min' => __("validation.min.numeric", ['attribute' => __('site.child_offer_percent'), 'min' => 1]),

            'children.*.offer_amount.numeric' => __("validation.numeric", ['attribute' => __('site.child_offer_amount')]),
            'children.*.offer_amount.min' => __("validation.min.numeric", ['attribute' => __('site.child_offer_amount'), 'min' => 1]),

            'children.*.offer_price.numeric' => __("validation.numeric", ['attribute' => __('site.child_offer_price')]),
            'children.*.offer_price.min' => __("validation.min.numeric", ['attribute' => __('site.child_offer_price'), 'min' => 1]),


        ];
    }

}
