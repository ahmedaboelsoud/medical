<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EducationRequest extends FormRequest
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
            'school' => 'required|max:250',
            'degree' => 'required|max:250',
            'grade' => 'required|max:100',
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
        'school.required' => __('doctors.school_required'),
        'school.max' => __('doctors.school_max'),
        'degree.required' => __('doctors.degree_required'),
        'degree.max' => __('doctors.degree_max'),
        'grade.required' => __('doctors.grade_required'),
        'grade.max' => __('doctors.grade_max'),
        'start_year.required' => __('doctors.start_year_required'),
        'start_month.required' => __('doctors.start_month_required'),
        'end_year.required' => __('doctors.end_year_required'),
        'end_month.required' => __('doctors.end_month_required'),
       ];
    }
}


// 'email' => 'required|email|unique:users,id,' . auth()->user()->id,
