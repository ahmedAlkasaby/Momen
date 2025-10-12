<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        return [
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'description.en' => 'nullable|string|max:500',
            'description.ar' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'order_id' => 'nullable|integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'name.ar.required' => __("validation.name_ar_required"),
            'name.ar.string' => __("validation.name_ar_string"),
            'name.ar.max' => __("validation.name_ar_max"),

            'name.en.required' => __("validation.name_en_required"),
            'name.en.string' => __("validation.name_en_string"),
            'name.en.max' => __("validation.name_en_max"),


            'description.en.max' => __("validation.description_en_max"),
            'description.en.required' => __("validation.description_en_required"),
            'description.en.string' => __("validation.description_en_string"),

            'description.ar.max' => __("validation.description_ar_max"),
            'description.ar.required' => __("validation.description_ar_required"),
            'description.ar.string' => __("validation.description_ar_string"),



            'image.image' => __("validation.image_image"),
            'image.mimes' => __("validation.image_mimes"),
            'image.max' => __("validation.image_max"),
            'image.required' => __("validation.image_required"),



            'order_id.integer' => __("validation.order_id_integer"),
            'order_id.min' => __("validation.order_id_min"),
            'order_id.max' => __("validation.order_id_max"),

        ];
    }
}
