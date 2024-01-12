<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AppointmentRequest extends FormRequest
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
            'doctor_id' => 'required',
            'patient_id' => 'required',
            'medicine' => 'nullable',
            'note' => 'nullable',
            'appdata' => 'required|date|after:today',
            'price' => 'nullable|numeric',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $role = $this->route()->parameter('patient');
            $rules['title'] = Rule::unique('patients')->ignore($role->id, 'id');
            $rules['email'] = Rule::unique('patients')->ignore($role->id, 'id');
            $rules['mobile'] = Rule::unique('patients')->ignore($role->id, 'id');
        }//end of if

        return $rules;

    }//end of rules

    public function messages()
    {
       return [
        'doctor_id.required' => __('doctors.name_required'),
        'appdata.required' => __('appointments.appdata_required'),
        'appdata.date' => __('appointments.appdata_date'),    
        'appdata.after' => __('appointments.appdata_after'), 
        'price.numeric' => __('appointments.price_number'), 
       ];
    }
}


// 'email' => 'required|email|unique:users,id,' . auth()->user()->id,
