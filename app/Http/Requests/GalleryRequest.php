<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\File;

class GalleryRequest extends FormRequest
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
        if($this->gallery == null) {
            return [
                "name" => "required|max:255",
                'file' => [
                    "required",
                    File::types(['png', 'jpg', 'jpeg'])
                        ->max(12 * 1024),
                ],
            ];
        } else {
            return [
                "name" => "required|max:255",
                "is_public" => "required",
                // 'file' => [
                //     "nullable",
                //     File::types(['png', 'jpg', 'jpeg'])
                //         ->max(12 * 1024),
                // ],
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
