<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users|string',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed|min:8|string',
            'code' => 'required|string',
            'token' => 'required|string',
            'device_type' => 'required|string|in:android,huawei,apple',
            'imei'=>'required|string',
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('auth.first_name')]),
            'last_name.required' => __('validation.required', ['attribute' => __('auth.last_name')]),
            'email.required' => __('validation.required', ['attribute' => __('auth.email')]),
            'email.unique' => __('validation.unique', ['attribute' => __('auth.email')]),
            'phone.required' => __('validation.required', ['attribute' => __('auth.phone')]),
            'phone.unique' => __('validation.unique', ['attribute' => __('auth.phone')]),
            'password.required' => __('validation.required', ['attribute' => __('auth.password')]),
            'code.required' => __('validation.required', ['attribute' => __('auth.code')]),
            'device_type.required' => __('validation.required', ['attribute' => __('auth.device_type')]),
            'device_type.in' => __('validation.in', ['attribute' => __('auth.device_type')]),
            'imei.required' => __('validation.required', ['attribute' => __('auth.imei')]),
        ];
    }
}
