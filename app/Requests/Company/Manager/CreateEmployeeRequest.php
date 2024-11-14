<?php

namespace App\Requests\Company\Manager;

use App\Enum\Role\RoleEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateEmployeeRequest extends FormRequest
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
            'name'          => 'required|regex:/^(?:[^"\'\<>])+$/i',
            'email'         => 'required|email',
            'phone'         => 'required|numeric|min:10',
            'address'       => 'required',
            'role'          => 'required|in:' . implode(',', [
                RoleEnum::MANAGER,
                RoleEnum::EMPLOYEE
            ])
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Name field cannot be empty.',
            'name.regex'            => 'Please enter a valid name format.',
            'email.required'        => 'Email field cannot be empty.',
            'email.email'           => 'Please input a valid email.',
            'phone.required'        => 'Please input a valid phone number.',
            'phone.numeric'         => "Phone number must be digits.",
            'phone.min'             => 'Phone number must be at least 10 digits.',
            'address.required'      => 'Please enter a valid address.',
            'role.required'         => 'Please enter a valid role.',
            'role.in'               => 'Available roles are: "manager", "employee"'
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
