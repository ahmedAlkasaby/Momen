<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title.en' => 'required|string|max:255',
            'title.ar' => 'required|string|max:255',
            'description.en' => 'required|string|max:500',
            'description.ar' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            "name.ar" => "required|string|max:255",
            "name.en" => "required|string|max:255",
            "orer_id" => "nullable|integer|min:0",

        ];
    }
    public function messages(): array
    {
        return [
            'title.en.required' => __("validation.title_en_required"),
            'title.ar.required' => __("validation.title_ar_required"),
            'description.en.required' => __("validation.description_en_required"),
            'description.ar.required' => __("validation.description_ar_required"),
            "name.ar.required" => __("validation.name_ar_required"),
            "name.en.required" => __("validation.name_en_required"),
            "orer_id.integer" => __("validation.order_id_integer"),

        ];
    }
}
