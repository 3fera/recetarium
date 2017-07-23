<?php

namespace App\Http\Requests\Recipes;

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
            'title'       => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'ingredients' => 'required|array',
            'steps'       => 'required|array',
        ];
    }
}
