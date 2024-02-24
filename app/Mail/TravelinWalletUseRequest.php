<?php

namespace App\Mail;

use App\Models\Settlement;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TravelinWalletUseRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $settlement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Settlement $settlement)
    {
        //
        $this->settlement = $settlement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Solicitud de liquidación a través de Monedero virtual de proveedor';
        $users = User::getHasPermission('AUTHORIZE_SERVICE_SETTLEMENT');
        $mails = $users->map(function ($user) {
            return $user->username;
        });

        $this->to($mails);
        $this->bcc(['jtzuc@dcitdev.com', 'christianflota@gmail.com']);
        return $this->view('emails.wallet_use_request');
    }
}
