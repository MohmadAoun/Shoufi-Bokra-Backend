<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'regex:/^[A-Za-z]{1,15}$/',
            'last_name' => 'regex:/^[A-Za-z]{1,15}$/',
            'phone_number' => 'string|regex:/^09\d{8}$/',
            'profile_image' => 'image|max:1024',
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.regex' => 'The phone number must be exactly 10 numbers starting with 09.',
            'first_name.regex' => 'The first name must only be letters and 15 charachters',
            'last_name.regex' => 'The last name must only be letters and 15 charachters'
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
