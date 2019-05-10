<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'city' => ['required'],
            'area' => ['required'],
            'phone1' => ['required', 'min:10' , 'max:10'],
            'phone2' => ['required', 'min:10' , 'max:10'],
            'address' => ['required', 'min:5'],
            'pincode' => ['required', 'min:6'],
        ];
    }
}
