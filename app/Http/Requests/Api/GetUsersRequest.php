<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetUsersRequest extends FormRequest
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
            'per_page' => 'nullable|integer|min:1|max:100',
            'page' => 'nullable|integer|min:1',
            'approval_status' => 'nullable|in:pending,approved,rejected',
            'user_type' => 'nullable|in:partisipan,tamu,komunitas',
            'is_ecosystem_builder' => 'nullable|boolean',
            'search' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'per_page.integer' => 'Items per page must be a number',
            'per_page.min' => 'Items per page must be at least 1',
            'per_page.max' => 'Items per page cannot exceed 100',
            'page.integer' => 'Page number must be a number',
            'page.min' => 'Page number must be at least 1',
            'approval_status.in' => 'Invalid approval status',
            'user_type.in' => 'Invalid user type',
            'is_ecosystem_builder.boolean' => 'Ecosystem builder flag must be true or false',
            'search.max' => 'Search query is too long',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}

