<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateGrade extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->isFaculty();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_id' => ['required', 'exists:App\Student,id'],
            'classroom_id' => ['required', 'exists:App\Classroom,id'],
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'Please provide a Student ID.',
            'student_id.exists' => 'Student does not exist or is unavailable.',
            'classroom_id.required' => 'Please provide a Classroom ID.',
            'classroom_id.exists' => 'Classroom does not exist.',
        ];
    }
}
