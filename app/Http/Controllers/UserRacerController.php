<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class UserRacerController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
         return view('admin.boost');
    }
	
	
	/* page */
	public function jordantest(){
		 return view('racer_event');
	}
	
	
	/* page */
	public function event_profile(){
		return view('racer_event_profile');
	}
	
	

   
}
