<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateValidationRequest extends FormRequest
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
        $userId = auth()->guard('web')->user()->id;
        return [
            'name'=>'required|string|min:3|max:100',
            'image'=>'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email'=>'required|email|max:255|unique:users,email,'.$userId,
            'password'=>'nullable|string|min:8|max:255|confirmed'
        ];
    }
}
