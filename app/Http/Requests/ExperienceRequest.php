<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExperienceRequest extends FormRequest
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
        $rules = [
            'title' => 'required|max:250',
            'company' => 'required|max:250',
            'start_year' => 'required',
            'start_month' => 'required',
            'end_year' => 'required',
            'end_month' => 'required',
        ];
        return $rules;
    }//end of rules

    public function messages()
    {
       return [
        'title.required' => __('doctors.title_required'),
        'title.max' => __('doctors.title_max'),
        'company.required' => __('doctors.company_required'),
        'company.max' => __('doctors.company_max'),
        'start_year.required' => __('doctors.start_year_required'),
        'start_month.required' => __('doctors.start_month_required'),
        'end_year.required' => __('doctors.end_year_required'),
        'end_month.required' => __('doctors.end_month_required'),
       ];
    }
}


// 'email' => 'required|email|unique:users,id,' . auth()->user()->id,
