<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Carbon\Carbon;

class DateRequest2 extends FormRequest
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
        $after_date =  Carbon::parse(Carbon::now()->addMonths(1))->format('Y-m-d');
        return [
            
            'date' => 'required|after:' . $after_date,
            'time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.after' => 'Only reserve a date with 1 months allowance',
        ];
    }
}
