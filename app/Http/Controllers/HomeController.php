<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view(admin_vw() . '.home');
    }

    public function noAccess()
    {
        return view('errors.404');
    }

    public function notFound()
    {
        return view('errors.404');
    }
}
