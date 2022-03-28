<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompromissoSave extends FormRequest
{

    protected $stopOnFirstFailure = false;

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
            'title' => 'required',
            'date_reminder' => 'required|date',
            'description' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'title.required' => 'É necessário informar um título.',
            'date_reminder.required' => 'É necessário informar uma data.',
            'description.required' => 'É necessário informar uma descrição.' 
        ];
    }
}
