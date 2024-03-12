<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PendingPayment extends Mailable
{
    use Queueable, SerializesModels;

    private $reservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Su reserva se ha confirmado y está pendiente de pago';
        $this->bcc(['programacion01@tripnow.mx', 'programacion02@tripnow.mx']);
        //$this->bcc(['jtzuc@dcitdev.com']);

        return $this->view('emails.pending_payment', ['reservation' => $this->reservation])
            ->attach(public_path('aviso-privacidad.pdf'), [
                'as' => 'Aviso de Privacidad.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
