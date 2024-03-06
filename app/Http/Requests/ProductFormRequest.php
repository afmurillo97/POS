<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'code' => strtoupper($this->code), // All in UPPER
            'name' => ucwords($this->name), // Every word start in UPPER
            'description' => ucfirst($this->description), // Only first letter start in UPPER
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
        return [
            'category_id' => 'required',
            'code' => 'required|max:255',
            'name' => 'required|max:255',
            'stock' => 'required|integer|min:0',
            'description' => 'max:255',
            'image' => 'mimes:jpeg,bmp,png'
        ];
    }
}


