<?php

namespace App\Mail;

use App\Models\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Gracias por confiar en TripNow, se han registrado correctamente tus datos';
        $this->to('srgiobernal@gmail.com');
        $this->bcc(['jtzuc@dcitdev.com', 'christianflota@gmail.com']);

        //$this->bcc(['jtzuc@dcitdev.com']);

        return $this->view('emails.welcome', ['reservation' => $this->customer]);
    }
}
