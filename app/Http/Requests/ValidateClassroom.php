<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class ValidateClassroom extends FormRequest
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
            'name' => ['required'],
            'department_id' => ['required', 'exists:App\Department,id'],
            'subject_id' => ['required', 'exists:App\Subject,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please provide a name.',
            'department_id.required' => 'Please provide a Department.',
            'department_id.exists' => 'Department provided is not available.',
            'subject_id.required' => 'Please provide a subject.',
            'subject_id.exists' => 'Subject provided is not available.',
        ];
    }
}
