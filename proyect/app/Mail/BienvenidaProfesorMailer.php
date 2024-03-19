<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BienvenidaProfesorMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre;
    public $correo;
    public $contraseña;

    /**
     * Create a new message instance.
     */
    public function __construct($nombre, $correo, $contraseña)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bienvenid@ ' . $this->nombre,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.profesor.bienvenida',
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
