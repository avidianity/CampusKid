<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateDepartment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'filled'],
            'abbreviation' => ['required', 'filled'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please provide a name.',
            'name.filled' => 'Name must not be empty.',
            'abbreviation.required' => 'Please provide an abbreviation.',
            'abbreviation.filled' => 'Abbreviation must not be empty.',
        ];
    }
}
