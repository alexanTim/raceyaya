<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Classesss\Common;
class AdminCategoryController extends Controller
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

        if(isset($_GET['action']))
        {

            if($_GET['action'] =='delete')
            {
                $id = $_GET['id'];
                DB::table('tbl_admin_category')->where('id',$id)->delete();           
            }

           

        }

        $result = DB::table('tbl_admin_category')->paginate(20);
         
        
        if( isset($_POST['search']))
        {
            $name = $_POST['search'];
            $result = DB::table('tbl_admin_category')
                      ->where('tbl_admin_category.name','LIKE',"%$name%")
                      ->paginate(20);
        }

        return view('admin.category', compact('result'));
    }

    /**
     *  Add New Cats
     */
    public function new_cat()
    {

        if($_POST ){
            if($_POST['mode']=='create')    
            DB::table('tbl_admin_category')->insert([
                'name' => $_POST['category_name']
            ]);
        }

        $category_name = '';     

        if(isset($_GET['action']) && !empty($_GET['action']))
        {   
            $id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
                    
            if($_GET['action'] =='edit')
            {
                // UPDATE
                if( isset($_POST['category_name']) )
                {
                    DB::table('tbl_admin_category')->where('id',$id)->update([
                        'name'=> $_POST['category_name']
                    ]);  
                }         
            }

            if($_GET['action'] =='delete')
            {
                DB::table('tbl_admin_category')->where('id',$_GET['id'])->delete();
            }

            $result =  DB::table('tbl_admin_category')->where('id',$id)->first();
            $category_name = $result->name;
        }


         // GET ALL QUERIESS          

        return view('admin.new_category',compact('category_name'));
    }  
}