<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \Carbon\Carbon;

class DateRequest1 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $after_date =  Carbon::parse(Carbon::now()->addMonths(2))->format('Y-m-d');
        return [
            'date' => 'required|after:' . $after_date,
            'time' => 'required',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date.after' => 'Only reserve a date with 2 months allowance',
        ];
    }
    }
}
