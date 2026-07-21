<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,mobile_number'],
            'email'         => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'role'          => ['required', 'string', 'in:admin,moderator,user'],
            'is_active'     => ['boolean']
        ];
    }
}
