<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaCreada extends Mailable
{
    public $reserva;

    public function __construct($reserva)
    {
        $this->reserva = $reserva;
    }

    public function build()
    {
        return $this->subject('Confirmación de Reserva - TUKO\'S')
                    ->view('emails.reserva');
    }
}
