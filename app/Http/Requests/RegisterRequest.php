<?php

namespace App\Http\Requests;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            // 'password' => 'required|string|min:8|confirmed',
        ];
    }
    /**
     * Get the validation error messages that apply to the reqeust.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array {
        return [
            'email.required' => 'Please enter your email',
            'name.required' => 'Please enter your name',
            'username.required' => 'Please enter your username',
            'username.unique' => 'This Username is already registered',
            'name.min' => 'Name must be at least 5 characters long',
            'name.max' => 'Name must be at most 255 characters long',
            'email.email' => 'Please enter a valid email address',
            'email.max' => 'Email address cannot exceed 255 characters',
            'email.unique' => 'This email address is already registered',
            'password.require' => 'Please enter you password',
        ];
    }
}
