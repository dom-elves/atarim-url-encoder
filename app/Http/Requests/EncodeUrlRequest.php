<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncodeUrlRequest extends FormRequest
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
            'url' => ['required','url:http,https'],
        ];
    }

    // error messages
    public function messages()
    {
        return [
            'url.required' => 'The URL field is required.',
            'url.url' => 'The URL field must be a valid URL.',
        ];
    }
}
