<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Store as StoreRequest;
use Hash;
use Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Edit account.
     *
     * @todo
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return view('auth.account', compact('user'));
    }

    /**
     * Save account.
     *
     * @param \App\Http\Requests\Auth\Store $request
     *
     * @todo Email confirmation.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $old_password = $request->input('old_password');
        $new_password = $request->input('password');
        $user = Auth::user();

        if ($new_password) {
            if ((Hash::check($user->password, Hash::make($old_password)))) {
                $user->password = Hash::make($new_password);
            } else {
                flash()->error('Contraseña actual incorrecta');

                return redirect(route('account'));
            }
        }

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $user->image = $request->file('image');
        }
        $user->save();

        flash()->success('Cuenta guardada!');

        return redirect(route('account'));
    }
}
