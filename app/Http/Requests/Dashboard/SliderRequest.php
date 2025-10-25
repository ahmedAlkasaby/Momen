<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        $slider = $request->input('id');

        return [
            "name.ar" => "required|string|max:255",
            "name.en" => "required|string|max:255",
            "image" => $slider ? "nullable|image|mimes:jpg,jpeg,png,svg" : "required|image|mimes:jpg,jpeg,png,svg",
            "product_id" => "nullable|required_without:link",
            "link" => "nullable|required_without:product_id",
            "description.ar" => "nullable",
            "description.en" => "nullable",
            "order_id" => "nullable|integer",
            "active" => "nullable|boolean",
        ];
    }
    public function messages()
    {
        return [
            'name.ar.required' => __("validation.name_ar_required"),
            'name.en.required' => __("validation.name_en_required"),
            'image.required' => __("validation.image_required"),
            'order_id.integer' => __("validation.order_id_integer"),
            'product_id.required_without' => __('validation.one_of_this_fields_required'),
            'link.required_without' => __('validation.one_of_this_fields_required'),

        ];
    }
    protected function prepareForValidation()
    {
        if ($this->input('product_id') === 'null') {
            $this->merge([
                'product_id' => null
            ]);
        }
    }
}
