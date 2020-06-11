<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateDetail extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'birthday' => ['required', 'date'],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'Please provide your first name.',
            'last_name.required' => 'Please provide your last name.',
            'gender.required' => 'Please select a gender.',
            'gender.in' => 'Please select a gender',
            'birthday.required' => 'Please provide your birthday.',
            'birthday.date' => 'Your birthday must be a valid date.',
            'address.required' => 'Please provide an address.',
        ];
    }
}
