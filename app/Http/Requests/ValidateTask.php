<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTask extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->ownsClassroom($this->input('classroom_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'deadline' => ['required', 'date'],
            'classroom_id' => ['required', 'exists:App\Classroom,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please provide a name.',
            'description.required' => 'Please provide a description.',
            'deadline.required' => 'Please set a deadline.',
            'deadline.date' => 'Please provide a valid deadline.',
            'classroom_id.required' => 'Please provide a Classroom ID.',
            'classroom_id.exists' => 'Classroom is not available.',
        ];
    }
}
