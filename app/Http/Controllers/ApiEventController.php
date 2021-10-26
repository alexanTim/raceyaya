<?php

namespace App\Http\Controllers;

use App\User;
use  DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiEventController extends Controller
{
    //
    public function getAllEvents(){
        $date = date('Y-m-d');
        $all = DB::table('tbl_organizer_event')
        ->where('create_event_status',1)
       ->get();
       
      
        return response()->json($all);
    }
}
