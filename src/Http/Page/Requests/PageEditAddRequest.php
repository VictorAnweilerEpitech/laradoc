<?php

namespace Victoranw\Laradoc\Http\Page\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

use ErrorC;

class PageEditAddRequest extends FormRequest
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
            'name' => 'string',
            'content' => 'string',
            'parent_id' => 'integer',
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
            'content.string' =>  "Le contenu n'est pas au bon format",
            'parent_id.required' =>  "Le dossier est obligatoire",
            'parent_id.string' =>  "Le dossier n'est pas au bon format",
        ];
    }
}
