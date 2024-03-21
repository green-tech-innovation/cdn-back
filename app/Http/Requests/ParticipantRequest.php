<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ParticipantRequest extends FormRequest
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
            "event_id" => "required|exists:events,id",
            "entity_id" => "required",
        ];
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors '.$this->entity_id,

            'data'      => $validator->errors()

        ], 400));
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'message.required' => 'Le nom de la catégorie est obligatoire',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'nom de la catégorie',
        ];
    }
}
