<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePost extends FormRequest
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
            'classroom_id' => ['required', 'exists:App\Classroom,id'],
            'body' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'classroom_id.required' => 'Please provide a Classroom ID.',
            'classroom_id.exists' => 'Classroom does not exist.',
            'body.required' => 'Please provide a body.',
        ];
    }
}
