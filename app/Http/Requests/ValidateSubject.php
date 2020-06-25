<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateSubject extends FormRequest
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
            'code' => ['required'],
            'name' => ['required'],
            'units' => ['required', 'numeric', 'min: 1'],
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Please provide a code.',
            'name.required' => 'Please provide a name.',
            'units.required' => 'Please provide units.',
            'units.numeric' => 'Units must be numeric.',
            'units.min' => 'Unit must not be zero.',
        ];
    }
}
