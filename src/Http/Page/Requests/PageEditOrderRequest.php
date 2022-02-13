<?php

namespace Victoranw\Laradoc\Http\Page\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

use ErrorC;

class PageEditOrderRequest extends FormRequest
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
        ];
    }
}
