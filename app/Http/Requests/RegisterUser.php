<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUser extends FormRequest
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
            'email' => ['required', 'email', 'unique:users'],
            'username' => ['required', 'min:6', 'unique:users'],
            'password' => ['required', 'min:6'],
            'access_level' => ['required', Rule::in([1, 2])],
            'department_id' => ['required', 'exists:App\Department,id'],
            'occupation_id' => [
                'required_if:access_level,2',
                'exists:App\Occupation,id',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please provide an email.',
            'email.email' => 'Please provide a valid email.',
            'email.unique' =>
                'Email is already registered. Did you mean to sign in?',
            'username.required' => 'Please provide a username',
            'username.min' => 'Username must be atleast 6 characters.',
            'username.unique' => 'Username is already taken.',
            'password.required' => 'Please provide a password.',
            'password.min' => 'Password must be atleast 6 characters.',
            'access_level.required' =>
                'Please provide an account type. (Student, Faculty)',
            'access_level.in' =>
                'Please choose either \'Student\' or \'Faculty\'.',
            'department_id.required' => 'Department is required.',
            'deparment_id.exists' => 'Department does not exist.',
            'occupation_id.required_if' => 'Occupation is required.',
            'occupation_id.exists' => 'Occupation does not exist.',
        ];
    }
}
