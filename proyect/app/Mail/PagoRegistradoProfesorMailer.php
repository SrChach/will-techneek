<?php

namespace App\Mail;

use App\Models\Clases;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagoRegistradoProfesorMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $infoClase;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($idClase, $idProfesor)
    {
        $this->infoClase = Clases::getFichaClaseForMailProfesor($idClase);
        $this->user = User::find($idProfesor);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pago De Clase N° '. $this->infoClase->idClase . ' ha sido registrado.',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.profesor.pagoRegistrado',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
