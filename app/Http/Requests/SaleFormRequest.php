<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaleFormRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        
    }

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
            'client_id' => 'required',
            'voucher_type' => 'required',
            'voucher_number' => [ Rule::unique('sales', 'voucher_number') ],
            'date' => 'nullable',
            'tax' => 'nullable|numeric',
            'total' => 'required|numeric'
        ];
        
    }
}
