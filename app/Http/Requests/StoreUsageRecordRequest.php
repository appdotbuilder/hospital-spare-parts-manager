<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsageRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'spare_part_id' => 'required|exists:spare_parts,id',
            'quantity_used' => 'required|integer|min:1',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'usage_date' => 'required|date|before_or_equal:today',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'spare_part_id.required' => 'Please select a spare part.',
            'spare_part_id.exists' => 'Selected spare part does not exist.',
            'quantity_used.required' => 'Quantity used is required.',
            'quantity_used.min' => 'Quantity used must be at least 1.',
            'purpose.required' => 'Purpose of usage is required.',
            'usage_date.required' => 'Usage date is required.',
            'usage_date.before_or_equal' => 'Usage date cannot be in the future.',
        ];
    }
}