<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorRequest extends FormRequest
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
            'name' => 'required|unique:users|max:100',
            'email' => 'required|email|unique:users|max:100',
           // 'mobile' => 'required|unique:users|digits:11',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
            'birthday' => 'required|date',
           // 'photo' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $role = $this->route()->parameter('doctor');
            $user_id = $role->user_id;
            $rules['photo'] = 'nullable';
            $rules['password'] = 'nullable';
            $rules['password_confirmation'] = 'nullable'; 
            $rules['name'] = ['required','max:100',Rule::unique('users')->ignore($user_id, 'id')];
            $rules['email'] = ['required','email','max:100',Rule::unique('users')->ignore($user_id, 'id')];
           // $rules['mobile'] = ['required','digits:11',Rule::unique('users')->ignore($user_id, 'id')];
        }//end of if

        return $rules;

    }//end of rules

    public function messages()
    {
       return [
        'name.required' => __('doctors.name_required'),
        'name.max' => __('doctors.name_max'),
        'name.unique' => __('doctors.name_unique'),
        'email.required' => __('patients.email_required'),
        'email.max' => __('patients.email_max'),
        'email.unique' => __('patients.email_unique'),
        'email.email' => __('patients.email_email'),
       // 'mobile.required' => __('patients.mobile_required'),
        //'mobile.digits' => __('patients.mobile_digits'),
        //'mobile.unique' => __('patients.mobile_unique'),
        'birthday.required' => __('patients.birthday_required'),
        'birthday.date' => __('patients.birthday_date'),
        'password.required' => __('doctors.password_required'),
        'password.min' => __('doctors.password_min'),
        'password.max' => __('doctors.password_max'),
        'password.confirmed' => __('doctors.confirmed'),
        'photo.required' => __('doctors.photo_required'),
        'password_confirmation.required' => __('doctors.password_confirmation_required'),
        'password_confirmation.min' => __('doctors.password_confirmation_min'),
        
       ];
    }
}


// 'email' => 'required|email|unique:users,id,' . auth()->user()->id,
