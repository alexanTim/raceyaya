<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use auth;

class CreateaccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {		
        if(Auth::check()){
            return redirect('/profile');
        }
        return view('create_account');
    }
}
