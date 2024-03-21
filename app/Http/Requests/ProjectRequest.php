<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class ProjectRequest extends FormRequest
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
        if($this->project == null) {
            return [
                "organe_id" => "required|exists:organes,id",
                'entity_id' => [
                    'required',
                    Rule::exists('entities', 'id')
                    ->where('type', "SECTOR"),
                ],
                "name" => "required|max:255",
                "target" => "required",
                "goal" => "required",
                "result" => "required",
                "cost" => "required",
                "date_start" => "required|date",
                "date_end" => "required|date|after:date_start",
                'file' => [
                    'required',
                    File::types(['pdf', 'docx'])
                        ->max(12 * 1024),
                ],
            ];
        } else {
            return [
                "entity_id" => "required|exists:entities,id",
                'entity_id' => [
                    'required',
                    Rule::exists('entities', 'id')
                    ->where('type', "SECTOR"),
                ],
                "name" => "required|max:255",
                "target" => "required",
                "goal" => "required",
                "result" => "required",
                "cost" => "required",
                "date_start" => "required|date",
                "date_end" => "required|date|after:date_start",
                // 'file' => [
                //     File::types(['pdf', 'docx'])
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
            'name.required' => 'Le nom du projet est obligatoire',
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
            'name' => 'nom du projet',
        ];
    }
}
