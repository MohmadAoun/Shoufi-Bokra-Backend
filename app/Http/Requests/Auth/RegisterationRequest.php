<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|regex:/^[A-Za-z]{1,15}$/',
            'last_name' => 'required|regex:/^[A-Za-z]{1,15}$/',
            'phone_number' => 'required|regex:/^09\d{8}$/',
            'password' => 'required|min:8',
            'role' => 'required|in:User,Organizer',
            'display_name' => 'required_if:role,Organizer',
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.regex' => 'The phone number must be exactly 10 numbers starting with 09.',
            'first_name.regex' => 'The first name must only contain letters and be up to 15 characters long.',
            'last_name.regex' => 'The last name must only contain letters and be up to 15 characters long.',
            'password.min' => 'The password must be at least 8 characters long.',
            'display_name.required_if' => 'The display name is required for organizers.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 400)
        );
    }
}