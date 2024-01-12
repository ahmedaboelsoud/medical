<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Super;


class PatientRequest extends FormRequest
{

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response =  Super::sendError('error validation', $validator->errors(),422);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
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
            'title' => 'required|unique:patients|max:100',
            'mobile' => 'required|unique:patients|digits:11',
            'email' => 'required|email|unique:patients|max:100',
            'job' => 'max:100',
            'birthday' => 'required|date',
            'height' => 'nullable|numeric|gt:0|lt:300',
            'weight' => 'nullable|numeric|gt:0|lt:500',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $role = $this->route()->parameters()['id'];
            $rules['title'] = ['required','max:100',Rule::unique('patients')->ignore($role, 'id')];
            $rules['email'] = ['required','email','max:100',Rule::unique('patients')->ignore($role, 'id')];
            $rules['mobile'] = ['required','digits:11',Rule::unique('patients')->ignore($role, 'id')];
        }//end of if

        return $rules;

    }//end of rules

    public function messages()
    {
       return [
        'title.required' => __('patients.name_required'),
        'title.max' => __('patients.title_max'),
        'title.unique' => __('patients.title_unique'),
        'mobile.required' => __('patients.mobile_required'),
        'mobile.digits' => __('patients.mobile_digits'),
        'mobile.unique' => __('patients.mobile_unique'),
        'email.required' => __('patients.email_required'),
        'email.max' => __('patients.email_max'),
        'email.unique' => __('patients.email_unique'),
        'email.email' => __('patients.email_email'),
        'job.max' => __('patients.jop_max'),
        'birthday.required' => __('patients.birthday_required'),
        'birthday.date' => __('patients.birthday_date'),
        'height.numeric' => __('patients.height_numeric'),
        'height.gt' => __('patients.height_gt'),
        'height.lt' => __('patients.height_lt'),
        'weight.numeric' => __('patients.weight_numeric'),
        'weight.gt' => __('patients.weight_gt'),
        'weight.lt' => __('patients.weight_lt'),
        
       ];
    }
}


// 'email' => 'required|email|unique:users,id,' . auth()->user()->id,
