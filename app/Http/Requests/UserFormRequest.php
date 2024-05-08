<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
        $passwordRule = ($this->getMethod() === 'PUT') ? 'nullable' : 'required';

        return [

            'name' => 'required|max:100',
            'role_id' => 'required',
            'email' => 'required|email',
            'password' => $passwordRule . '|min:6'

        ];
    }
}
