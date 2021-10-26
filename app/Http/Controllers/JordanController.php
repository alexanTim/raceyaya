<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class JordanController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

	public function racesevents(){
		 return view('racesevents');
	}
	
	public function racedetails(){
		 return view('race-details');
	}
   
}
