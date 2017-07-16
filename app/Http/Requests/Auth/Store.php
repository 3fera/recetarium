<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class Store extends Request
{
    /**
     * Authorization.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'        => 'mimes:jpeg,png',
            'name'         => 'required',
            'username'     => 'required|exists:users,username,id,' . Auth::user()->id,
            'email'        => 'required|exists:users,email,id,' . Auth::user()->id,
            'old_password' => 'required_with:password,password_confirmation',
            'password'     => 'confirmed',
        ];
    }
}
