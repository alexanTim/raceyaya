<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
class CurrencyController extends Controller
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
        $name = $_GET['country'];

        $result = DB::table('tbl_country')->where('name', $name)->get();
        $a ='';

        if(!$result->isEmpty()){
            foreach($result as $aa){
                $a = $aa->currency;
            }
        }
        $a = array('name'=>$a);
        return response()->json($a);
    }
}
