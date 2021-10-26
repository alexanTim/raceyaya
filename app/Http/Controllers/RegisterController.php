<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {		
        
        $response = array('msg'=>'test this is the tinapay corner');
        return response()->json($response);
    }
}
