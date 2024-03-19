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

class ClaseProgramadaProfesorMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $infoClase;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($idClase, $user)
    {
        $this->infoClase = Clases::getFichaClaseForMailProfesor($idClase);
        $this->user = User::find($user);

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva Clase Programada',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.profesor.claseProgramada',
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
