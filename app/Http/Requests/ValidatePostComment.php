<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePostComment extends FormRequest
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
            'body' => ['required'],
            'post_id' => ['required', 'exists:App\Post,id'],
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'Please provide a body.',
            'post_id.required' => 'Please provide a Post ID.',
            'post_id.exists' => 'Post is not available.',
        ];
    }
}
