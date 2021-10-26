<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BanknotificationSocial extends Mailable
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
        //
        //$this->email = $data['email'];
        //$this->password = $data['password'];
        $this->firstname = $data['firstname'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		//$user = 'alex';
        //return $this->view('email.email');
        return $this->view('email.sendbanknotificationsocial')
        ->from('jordan@panalosolutions.com', 'RaceYaya')
        ->subject('Pending Payment')
        ->replyTo('alext@panalosolutions.com', 'RaceYaya')
        ->with([
            'firstname' => $this->firstname,
           // 'password' =>  $this->password      
        ]);
    }
}
