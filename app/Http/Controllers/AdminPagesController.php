<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Classesss\Common;
class AdminPagesController  extends Controller
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
     $new = new Common();
            
     $new->checkifAdmin(); 
         return view('admin');
    }

   
}
