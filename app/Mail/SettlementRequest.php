<?php

namespace App\Mail;

use App\Models\Settlement;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SettlementRequest extends Mailable
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
        $this->subject = 'Solicitud de liquidación de servicio con transferencia';
        $users = User::getHasPermission('AUTHORIZE_SERVICE_SETTLEMENT');
        $mails = $users->map(function ($user) {
            return $user->username;
        });

        $this->to($mails);
        $this->bcc(['programacion01@tripnow.mx', 'programacion02@tripnow.mx']);
        return $this->view('emails.transfer_settlement_request');
    }
}
