<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
        $key = $this->input('key');
        $setting = Setting::where('key', $key)->first();
        return [
            'key'   => 'required|string|max:255|exists:settings,key',
            'value' => $setting ? $setting->validation_rules : 'nullable',
        ];
    }
}
