<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

        if($this->method() == 'POST') {
            return [
                'name' => 'required',
                'email' => 'required|unique:users',
                'mobile' => 'required|unique:users|digits:11',
                'password' => 'required|min:8',
            ];
        }

        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'mobile' => 'required',
            'password' => 'nullable|min:8',
        ];
    }
}
