<?php

namespace App\Mail;

use App\Models\Pedidos;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagoPedidoAlumnoMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $infoPedido;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($idPedido, $user)
    {
        $this->infoPedido = Pedidos::infoPedidoForMail($idPedido);
        $this->user = User::find($user);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pedido Pagado - Folio ' . $this->infoPedido->folio,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.alumno.pagoPedido',
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
