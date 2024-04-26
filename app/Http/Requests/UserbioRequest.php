<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserbioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'first_name'   		    => 'required|max:51',
            'last_name'         	=> 'required|max:51',
            'dob'           	    => 'required|date_format:Y-m-d|after:1979-12-31',
            'email'                 => 'required|email|string|min:4|max:99',
            'phone_number'          => 'required|min:8|max:15',
            'religion'			    => 'required',
            'community'			    => 'required',
            'mother_tongue'		    => 'required',
            'state'                 => 'required',
            'city' 				    => 'required',
            'live_with_family'	    => 'required',
            'marital_status'	    => 'required',
            'diet' 				    => 'required',
            'height'			    => 'required',
            'horoscope_require'	    => 'required',
            'manglik'			    => 'required',
            'highest_qualification'	=> 'required',
            'company_name'			=> 'required',
            'income_type'			=> 'required',
            'position' 				=> 'required',
            'income'				=> 'required',
            'cast'				    => 'required',
            'sub_cast'			    => 'required',
            'family_type'		    => 'required',
            'father_occupation'	    => 'required',
            'brother'			    => 'required',
            'sister'			    => 'required',
            'family_living_in'	    => 'required',
            'family_bio'		    => 'required',
            'family_address'	    => 'required',
            'family_contact_no'		=> 'required',
            'about'				    => 'required',
            'document_type'		    => 'required|max:3',
            'document_number'	    => 'required|max:32',
            'document'			    => 'nullable',
            'profile_image'         => 'nullable',
            'cover_image'           => 'nullable',
        ];
    }
}
