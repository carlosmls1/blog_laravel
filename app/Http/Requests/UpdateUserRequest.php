<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user = request()->route('user');

        return [
            'email' => 'required|email:rfc,dns|unique:users,email,'.$user->id,
            'name' => 'required',
            'users'=>'json'

        ];
    }
}
