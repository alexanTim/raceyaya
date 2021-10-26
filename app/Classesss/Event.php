<?php
namespace App\Classesss;
use DB;
use Illuminate\Support\Facades\Auth;

class Event {
	public function getCategorySports(){
        return DB::table("tbl_admin_category")->get();
    }
} 
?>