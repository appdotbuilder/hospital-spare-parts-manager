<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSparePartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->is_manager ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:spare_parts,code,' . $this->route('spare_part')->id,
            'quantity' => 'required|integer|min:0',
            'storage_location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
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
            'name.required' => 'Spare part name is required.',
            'code.required' => 'Spare part code is required.',
            'code.unique' => 'This spare part code is already used by another spare part.',
            'quantity.required' => 'Quantity is required.',
            'quantity.min' => 'Quantity cannot be negative.',
            'storage_location.required' => 'Storage location is required.',
            'price.required' => 'Price is required.',
            'price.min' => 'Price cannot be negative.',
            'minimum_stock.required' => 'Minimum stock level is required.',
            'minimum_stock.min' => 'Minimum stock cannot be negative.',
        ];
    }
}