<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BananahubRequest extends FormRequest
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
            'first_name'           =>'required | regex:/^[a-zA-Z]/',
            'last_name'            =>'required | regex:/^[a-zA-Z]/ ',
            'email'                =>'required | email',
            'type_of_banana_Chips' =>'required',
            'mobile_number'        =>'required |integer|min_digits:10|max_digits:10',
            'date'                 =>'required |date',
            'pincode'              =>'required |integer',
            'price'                =>'required |integer',
           'address'               =>'required |regex:/^[a-zA-Z0-9]/',
            
        ];
    }

    public function messages()
    {
        return[

            'first_name.required'           =>'*',
            'last_name.required'            =>'*',
            'email.required'                =>'*',
            'type_of_banana_Chips.required' =>'*',
            'mobile_number.required'        =>'*',
            'date.required'                 =>'*',
            'pincode.required'              =>'*',
            'price.required'                =>'*',
            'address.required'              =>'*',     
        ];
    }
}