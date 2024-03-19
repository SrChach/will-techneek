<?php

namespace App\Notifications;

use App\Http\Controllers\FechaController;
use App\Models\Clases;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CalificarProfesor extends Notification
{
    use Queueable;

    public $infoClase;

    /**
     * Create a new notification instance.
     */
    public function __construct($idClase)
    {
        $this->infoClase = Clases::getFichaClase($idClase);
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
            "id_clase" => $this->infoClase->idClase,
            "mensaje" => "¿Cómo estuvo tu clase de " . $this->infoClase->materiaNombre . "? No olvides calificar a tu profesor " . $this->infoClase->nombre,
            "url" => "#",
            "color" => "bg-success",
            "icon" => '<i class="mdi mdi-book-clock"></i>' 
        ];
    }
}
