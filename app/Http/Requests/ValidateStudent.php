<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ValidateStudent extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !$this->user()->isStudent();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'unique:users', 'email'],
            'username' => ['required', 'unique:users'],
            'password' => ['required', 'min:6'],
            'department_id' => ['required', 'exists:App\Department,id'],
            'detail.first_name' => 'required',
            'detail.last_name' => 'required',
            'detail.gender' => ['required', Rule::in(['Male', 'Female'])],
            'detail.birthday' => ['required', 'date'],
            'detail.address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please provide an email.',
            'email.unique' => 'Email is already taken.',
            'email.email' => 'Please provide a valid email.',
            'username.required' => 'Please provide a username.',
            'username.unique' => 'Username is already taken.',
            'password.required' => 'Please provide a password.',
            'password.min' => 'Password must be atleast 6 characters.',
            'department_id.required' => 'Please provide a department',
            'department_id.exists' => 'Department provided is not available.',
            'detail.first_name.required' => 'Please provide your first name.',
            'detail.last_name.required' => 'Please provide your last name.',
            'detail.gender.required' => 'Please select a gender.',
            'detail.gender.in' => 'Please select a gender',
            'detail.birthday.required' => 'Please provide your birthday.',
            'detail.birthday.date' => 'Your birthday must be a valid date.',
            'detail.address.required' => 'Please provide an address.',
        ];
    }
}
