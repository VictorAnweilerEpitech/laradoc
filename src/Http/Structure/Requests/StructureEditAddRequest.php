<?php

namespace Victoranw\Laradoc\Http\Structure\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

use ErrorC;

class StructureEditAddRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'parent_id' => 'nullable|integer',
        ];
    }
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' =>  "Le nom est obligatoire",
            'name.string' =>  "Le nom n'est pas au bon format",
            'parent_id.integer' =>  "Le parent n'est pas au bon format",
        ];
    }
}
