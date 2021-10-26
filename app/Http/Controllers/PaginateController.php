<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PaginateController extends Controller
{
    public function index()
    {
        $posts = DB::table('tbl_post')->paginate(2);    
            $response = [
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem()
            ],
            'data' => $posts
        ];        return response()->json($response);
    }

    public function onclick()
    {        
        $array = '<form action="http://youtube.com"> <input type="text" name="dsfd"><input type="submit"></form>';
        return response()->json(array('html'=>$array));
    }
}
