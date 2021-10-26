<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Classesss\Validate;
use App\Mail\SendContact;
class ContactController extends Controller
{
	 public function __construct()
    {
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $r)
    {
         $message_contact = '';
         if($r->input('send-message')=='send')
         {

            //$vali = new Validate();
            //$c = $vali->startValidate($r);

            //if( $c['error']){
                
                // send email 
                $data = array(
                              'name'=> $_POST['yourname'],
                              'phone' => $_POST['yourphone'],
                              'email'    => $_POST['youremail'],
                              'subject'  => $_POST['subject'],
                              'message'  => $_POST['message']
                             );
       
        Mail::to('sales@raceyaya.com')->send(new SendContact($data));
             
        if (Mail::failures()) {
         $message_contact =  '<ul class="error_contact">Contact email failed.</ul>';  
         
        }else{
        
         $message_contact =  '<ul class="contact_success"><li>Contact has been successfully sent.</li></ul>';
        }           
             
          
         }
         return view('contact', compact('message_contact'));
    }

    public function d(){
       die();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
	
	public function contactus(){
		 print_r($_POST);
		 die();
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function show(Organizer $organizer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function edit(Organizer $organizer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organizer $organizer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organizer  $organizer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organizer $organizer)
    {
        //
    }
}
