<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EntityRequest extends FormRequest
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
        if($this->entity == null) {
            return [
                "category_id" => "max:255|exists:categories,id",
                "user_id" => "required|max:255|exists:users,id|unique:entities,user_id",
                "name" => "required|max:255|unique:entities,name",
                "description" => "required",
                "type" => "required|max:255",
                "email" => "required|max:255",
                "phone" => "required|max:255",
                "address" => "max:255",
            ];
        } else {
            return [
                "category_id" => "max:255|exists:categories,id",
                "user_id" => "required|max:255|exists:users,id|unique:entities,user_id,".$this->entity->id,
                "name" => "required|max:255|unique:entities,name,".$this->entity->id,
                "description" => "required",
                "type" => "required|max:255",
                "email" => "required|max:255",
                "phone" => "required|max:255",
                "address" => "required|max:255",
            ];
        }
    }

    public function failedValidation(Validator $validator){

        throw new HttpResponseException(response()->json([

            'success'   => false,

            'message'   => 'Validation errors',

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
            'name.required' => 'Le nom de la catégorie est obligatoire',
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
