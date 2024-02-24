<?php

namespace App\Mail;

use App\Models\Reservation;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmation extends Mailable
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
        $this->subject = 'Su reserva ha sido confirmada';
        $this->to($this->reservation->customer->email);
        $this->bcc(['jtzuc@dcitdev.com', 'christianflota@gmail.com', 'soportes@tripnow.com']);

        $this->view('emails.reservation_confirmation', ['reservation' => $this->reservation])
            ->attach(public_path('aviso-privacidad.pdf'), [
                'as' => 'Aviso de Privacidad.pdf',
                'mime' => 'application/pdf',
            ]);

        foreach ($this->reservation->reservation_details as $detail) {
            $filename = 'voucher_';
            switch ($detail->reservable_type) {
                case 'App/Models/HotelReservation':
                    $filename = $filename . 'hotel';
                    break;
                case 'App/Models/TourReservation':
                    $filename = $filename . 'tour';
                    break;
                case 'App/Models/FlightReservation':
                    $filename = $filename . 'flight';
                    break;
                case 'App/Models/CarRentalReservation':
                    $filename = $filename . 'car_rental';
                    break;
                case 'App/Models/PickupReservation':
                    $filename = $filename . 'pickup';
                    break;
            }
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::setOptions(
                [
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                ])->loadView('pdf.voucher', ['reservation_detail' => $detail]);
            $pdf->getDomPDF()->setHttpContext(
                stream_context_create([
                    'ssl' => [
                        'allow_self_signed'=> TRUE,
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                    ]
                ])
            );
            $this->attachData($pdf->output(), $filename . '.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

        return $this;
    }
}
