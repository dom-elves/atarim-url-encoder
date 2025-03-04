<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DecodeUrlRequest extends FormRequest
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
            'decoded-url' => ['required','url:http,https', 'exists:urls,encoded_url'],
        ];
    }

    // error messages
    public function messages(): array
    {
        return [
            'decoded-url.required' => 'The URL field is required.',
            'decoded-url.url' => 'The URL field must be a valid URL.',
            'decoded-url.exists' => 'The URL field must be a valid encoded URL.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = response()->json([
            'errors' => $validator->errors(),
        ], 422);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
