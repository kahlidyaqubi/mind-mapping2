<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

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
        $links = [];
        return view(admin_vw() . '.home',$links);
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
