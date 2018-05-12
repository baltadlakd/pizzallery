<?php

namespace pizzallery\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $request->user()->authorizeRoles(['user','admin']);
        return view('home');
    }
    public function privacy()
    {
        return view('privacy');
    }
    public function admin(Request $request){
      return view('home.admin');
    }
}
