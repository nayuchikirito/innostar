<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
class CustomDateRequest extends FormRequest
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
            'date2' => 'required|after:' . $after_date,
            'time2' => 'required',
            'status' => 'required',
            'service_id2' => 'required',
            'package_id2' => 'required',
            
        ];
    }

    public function messages()
    {
        return [
            'date2.after' => 'Only reserve a date with 2 months allowance',
        ];
    }
}
