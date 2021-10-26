<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Shopinquiry extends Mailable
{
    use Queueable, SerializesModels;
    public  $email;
     public  $firstname;
    public  $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {	
        $this->firstname  = $data['firstname'];
		$this->lastname   = $data['lastname'];
		$this->email 	  = $data['email'];
		$this->contact 	  = $data['contact'];
		$this->msg 	      = $data['msg'];	
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.send_shop_inquiry')
        ->from('jordan@panalosolutions.com', 'RaceYaya')
        ->subject('Pending Payment')
        ->replyTo('alext@panalosolutions.com', 'RaceYaya')
        ->with([
				'firstname' => $this->firstname,
				'lastname'  => $this->lastname,
				'email' 	=> $this->email,
				'contact'   => $this->contact,
				'msg'       => $this->msg              
			   ]);
    }
}
