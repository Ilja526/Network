<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupPostRequest extends FormRequest
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
            'content'=>'nullable|string|max:999',
            'image'=>'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'file'=>'nullable|file|mimes:docx,pdf,xlsx|max:2048'
        ];
    }
}
