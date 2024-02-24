<?php

namespace App\Mail;

use App\Models\ReservationPaymentDate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReminder extends Mailable
{
    use Queueable, SerializesModels;

    private $paymentDate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ReservationPaymentDate $paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject = 'Recordatorio de pago';
        $this->to($this->paymentDate->reservation->customer->email);
        $this->bcc(['jtzuc@dcitdev.com', 'christianflota@gmail.com', 'soportes@tripnow.com']);

        return $this->view('emails.payment_reminder', ['reservation' => $this->paymentDate]);
    }
}
