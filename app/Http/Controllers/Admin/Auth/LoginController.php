<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;


class LoginController extends Controller
{

    /*
       |--------------------------------------------------------------------------
       | Login Controller
       |--------------------------------------------------------------------------
       |
       | This controller handles authenticating users for the application and
       | redirecting them to your home screen. The controller uses a trait
       | to conveniently provide its functionality to your applications.
       |
       */
    //use AuthenticatesUsers;


    public function __construct()
    {
       // $this->middleware('guest:admin')->except('logout');
    }

    public function login()
    {
        return view(admin_vw() .'.auth.login');
    }

    public function postLogin(AdminRequest $request)
    {
        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {
            return redirect()->intended('admin/home');
        }
        return back()->withInput($request->only('email', 'remember'));
    }

	
	  public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect()->route('admin.login');
    }


}
