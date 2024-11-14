<?php

namespace App\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => 'Email field cannot be empty.',
            'email.email'           => 'Please input a valid email.',
            'password.required'     => 'Password field cannot be empty.',
            'password.min'          => 'Password must be atleast 8 characters.'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error'   => true,
            'message' => 'Validation failed.',
            'errors'  => $validator->errors(),
            'data'    => null,
            'status'  => 400
        ], 400));
    }
}
