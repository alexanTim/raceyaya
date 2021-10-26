<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class FourOfourController extends Controller
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
        die('404 - can\'t find the page');
    }
}
