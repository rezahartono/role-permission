<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthenticationController extends Controller
{
    /**
     * Login view
     *
     */
    public function login()
    {
        return view('pages.auth.login');
    }

    /**
     * Login Action
     *
     */
    public function doLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:255',
                'password' => 'required|max:255',
            ]);

            //if validation fails
            if ($validator->fails()) {
                return back()->withErrors($validator->errors());
            }

            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();

                return redirect()->intended('dashboard');
            } else {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->onlyInput('email');
            }
        } catch (\Throwable $th) {
            Alert::error('Error Occured!', $th);
            return back();
        }
    }
}
