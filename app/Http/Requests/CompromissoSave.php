<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompromissoSave extends FormRequest
{

    private $horasDeAtencedencia;

    public function __construct()
    {
        $this->horasDeAtencedencia = 12;
    }


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
            'date_reminder' => 'required|date|after_or_equal:'.date('Y-m-d\TH:i:s', (time() + ($this->horasDeAtencedencia * 60 * 60))),
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'É necessário informar um título.',
            'date_reminder.required' => 'É necessário informar uma data.',
            'description.required' => 'É necessário informar uma descrição.',
            'date_reminder.date' => 'Data de lembrete inválida.',
            'date_reminder.after_or_equal' => "Você deve cadastrar um lembrete com pelo menos {$this->horasDeAtencedencia} horas de atencedência." 
        ];
    }
}
