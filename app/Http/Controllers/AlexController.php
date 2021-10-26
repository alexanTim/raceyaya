<?php

namespace App\Http\Controllers;

use App\User;
use  DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Classes\dog;
use App\Classesss\Validate;
class AlexController extends Controller
{
    //
    public function index(){
        $d1s = DB::table('users')->get();
        print_r($d1s);
        die();
        /*
         $d1s = DB::table('area as a')
        ->select('a.*', DB::raw(' count(b.d1) as num '))
        ->leftJoin('article as b', 'a.id', '=', 'b.d1')
        ->where(['a.level' => 1])
        ->groupBy('a.id')
        ->orderBy('a.level', 'ASC')
        ->orderBy('a.sortid', 'ASC')
        ->get();
         */
    }
}
