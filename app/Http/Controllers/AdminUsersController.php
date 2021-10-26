<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Classesss\Common;
class AdminUsersController extends Controller
{
	  public function __construct()
    {}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new = new Common();
            
        $new->checkifAdmin(); 
        
        // why 3 = 3 is racer
        $result = DB::table('users')
                  ->where('user_type',3)
                  ->where('is_approved',1)
                  ->paginate(50);
            
        if(isset($_GET['r'])){

            $resultss = DB::table('users')->where('user_type',3)->get();
            $delimiter = ",";
            $filename = "RY-RACER-" . date('Y-m-d') . ".csv";
            $location = '';

            if( count($resultss) > 0) 
            {
     
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                header('Pragma: no-cache');
                header('Expires: 0');

                // clean output buffer
                ob_end_clean();

                $f = fopen('php://output', 'w');
     
                $title = array('Table Registration');
                       
                $fields = array( 'First Name',
                                 'Last Name',            
                                 'Email',
                                 'Zip',
                                 'City',
                                 'State',
                                 'Password',                                  
                                 'Phone' ,
                                 'Address',
                                 'Username',
                                 'Date of Birth',
                                 'Gender',
                                 'Club',
                                 'Company',
                                 'Country',
                                 'Nationality'                                                                         
                                );
                   
                    fputcsv($f, $fields, $delimiter);
                    
                    //output each row of the data, format line as csv and write to file pointer
                    foreach($resultss as $row)
                    {                     
                        $lineData = array(  $row->first_name,  
                                            $row->last_name,  
                                            $row->email,
                                            $row->zip,
                                            $row->city,
                                            $row->state,
                                            $row->password,                                           
                                            $row->phone,
                                            $row->address,
                                            $row->username,
                                            $row->date_birth,
                                            $row->gender,
                                            $row->club ,
                                            $row->company,
                                            $row->country,
                                            $row->nationality,
                                        );
                        fputcsv($f, $lineData, $delimiter);
                    }
                fclose( $f );
                exit;
            }
        }

        if( !empty($_POST['search']) )
        {
            $name = $_POST['search'];
            
            $result = DB::table('users')
                      ->where('is_approved',1)
                      ->where('user_type',3)                     
                      ->where('first_name','LIKE',"%$name%")
                      ->orwhere(function($result) use ($name){
                          return $result ->where('is_approved',1)
                                         ->where('last_name','LIKE',"%$name%");                                     
                      })->paginate(50);
        }else{  
            
            if(isset($_POST['country_filter'])){
                if(!empty($_POST['country_filter'])){
                    $country_filter = $_POST['country_filter'];
                    $result = DB::table('users')
                            ->where('is_approved',1)
                            ->where('user_type',3)
                            ->where('country',$country_filter)
                            ->paginate(50);
                }
            }
        }

        return view('admin.users',compact('result'));
    }   
}