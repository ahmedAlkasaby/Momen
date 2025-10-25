<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = $request->input('id');
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => $userId ? 'required|string|regex:/^01[0125][0-9]{8}$/|unique:users,phone,' . $userId : 'required|string|regex:/^01[0125][0-9]{8}$/|unique:users,phone',
            'email' => $userId ? 'required|string|email|unique:users,email,' . $userId : 'required|email|unique:users,email',
            'password' => $userId ? 'nullable|confirmed|min:8|max:32' : 'required|confirmed|min:8|max:32',
            "roles.*" => "required|exists:roles,id",
            "vip" => "boolean",
            "notify" => "boolean",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "Lang" => "in:ar,en",
            "type" => "required"
        ];
    }
}
