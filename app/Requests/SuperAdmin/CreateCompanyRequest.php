<?php

namespace App\Requests\SuperAdmin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCompanyRequest extends FormRequest
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
            'manager_name'  => 'required|regex:/^(?:[^"\'\<>])+$/i',
            'manager_email' => 'required|email',
            'name'          => 'required|regex:/^(?:[^"\'\<>])+$/i',
            'email'         => 'required|email',
            'phone'         => 'required|numeric|min:10',
        ];
    }

    public function messages()
    {
        return [
            'manager_name.required' => 'Manager name field cannot be empty.',
            'manager_name.regex'    => 'Please enter a valid name format for manager.',
            'manager_email.required' => 'Manager email field cannot be empty.',
            'manager_email.email'   => 'Please input a valid email for manager.',
            'name.required'         => 'Name field cannot be empty.',
            'name.regex'            => 'Please enter a valid name format.',
            'email.required'        => 'Email field cannot be empty.',
            'email.email'           => 'Please input a valid email.',
            'phone.required'        => 'Please input a valid phone number.',
            'phone.numeric'         => "Phone number must be digits.",
            'phone.min'             => 'Phone number must be at least 10 digits.',
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
