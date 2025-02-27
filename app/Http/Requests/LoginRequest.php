<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            // 'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
        ];
    }
    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array {
        return [
            // 'email.required' => 'Please enter the registered email address',
            // 'email.email' => 'Please enter a valid email address',
            'username.required' => 'Username is required.',
            'username.accepted' => 'Username should be accepted.',
            'username.valid' => 'Username should be valid.',
            'password.required' => 'Password is required.',
        ];
    }
}
