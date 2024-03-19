<?php

namespace App\Notifications;

use App\Models\Pedidos;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoEstatus extends Notification
{
    use Queueable;

    public $pedido;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pedidos $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            "id_pedido" => $this->pedido->id,
            "mensaje" => "Muchas gracias, tu pedido ha sido registrado, ahora por favor agenda tus clases.",
            "url" => route('pedido.resumen', $this->pedido->folio),
            "color" => "bg-primary",
            "icon" => '<i class="mdi mdi-book"></i>' 
        ];
    }
}
