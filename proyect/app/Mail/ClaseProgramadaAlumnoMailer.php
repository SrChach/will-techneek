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

class ClaseProgramadaAlumnoMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $infoClase;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($idClase, $user)
    {
        
        $this->infoClase = Clases::getFichaClase($idClase);
        $this->user = User::find($user);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Clase N° ' . $this->infoClase->idClase . ' Programada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.alumno.claseProgramada',
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
