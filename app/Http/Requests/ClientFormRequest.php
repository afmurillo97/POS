<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientFormRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => ucwords($this->name), // Every word start in UPPER
            'client_type' => strtoupper($this->client_type), // All in UPPER
            'address' => ucwords($this->address), // Every word start in UPPER
        ]);
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
        $idNumberRule = ($this->getMethod() === 'PUT') ? 'nullable' : 'required'; 

        return [
            'name' => 'required|max:255',
            'client_type' => 'required|max:50',
            'id_type' => 'required|max:50',
            'id_number' => [
                $idNumberRule, 
                'numeric', 
                'regex:/^\d{1,12}$/', 
                Rule::unique('clients', 'id_number')
            ],
            'address' => 'nullable|max:255',
            'phone' => ['nullable', 'numeric', 'regex:/^\d{1,12}$/'],
            'email' => 'required|email|max:100',
        ];
    }
}
