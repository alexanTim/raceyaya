<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class Sendboost extends Mailable
{
    use Queueable, SerializesModels;
    public  $email;
    public  $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->email = $data['email'];
        //$this->password = $data['password'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.sendboost')
        ->from('jordan@panalosolutions.com', 'RaceYaya')
        ->subject('Hello & Welcome!')
        ->replyTo('alext@panalosolutions.com', 'RaceYaya')
        ->with([
                 'email' => $this->email,
                 // 'password' =>  $this->password      
               ]);
    }
}
