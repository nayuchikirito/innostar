<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Carbon\Carbon;

class ReservationDateRequest extends FormRequest
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
        $after_date =  Carbon::parse(Carbon::now()->addMonths(2))->format('Y-m-d');
        return [
            'date' => 'required|after:' . $after_date,
            'time' => 'required',
            'status' => 'required',
            'balance' => 'required|numeric',
            'client_id' => 'required',
            'service_id' => 'required',
            'package_id' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            'date.after' => 'Only reserve a date with 2 months allowance',
        ];
    }
}
            


