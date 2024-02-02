<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class EventRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|max=45',
            'description' => 'required',
            'type_id' => 'required',
            'genre_id' => 'required',
            'sub_genre_id' => 'required',
            'locatoin_id' => 'required',
            'event_start_date' => 'required',
            'event_end_date' => 'required',
            'ticket_book_start_date' => 'required',
            'ticket_book_end_date' => 'required',
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
