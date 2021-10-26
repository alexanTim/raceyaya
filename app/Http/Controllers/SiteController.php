<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Shopinquiry;

class SiteController extends Controller
{
    //
    public function term_of_use(){        
        return view('term-of-use');
    }

    public function inquiry(){
        $firstname  = $_POST['contact_order_firstname'];
        $lastname  = $_POST['contact_order_lastname'];
        $email  = $_POST['contact_order_email_address'];
        $contact_order  = $_POST['contact_order_contact'];
        $message  = $_POST['contact_order_message'];

        $data = array(
                      'firstname'=>$firstname,
                      'lastname'=>$lastname,
                      'email'=>$email,
                      'contact_order'=>$contact_order,
                      'msg'=>$message
                     );
      
        Mail::to('alext@panalosolutions.com')->send(new Shopinquiry($data));
        
         return view('inquiry_order_thankyou');
    }
}
