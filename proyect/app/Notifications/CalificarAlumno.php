<?php

namespace App\Notifications;

use App\Models\Clases;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CalificarAlumno extends Notification
{
    use Queueable;

    public $infoClase;
    public $infoAlummno;

    /**
     * Create a new notification instance.
     */
    public function __construct($idClase)
    {
        $this->infoClase = Clases::getFichaClase($idClase);
        $this->infoAlummno = User::select('users.nombre AS nombreAluno')
            ->join('pedidos', 'users.id', '=', 'pedidos.idAlumno')
            ->join('clases', 'pedidos.id', '=', 'clases.idPedido')
            ->where('clases.id', $idClase)
            ->first();
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
            "mensaje" => "No olvides llenar la bitácora de clase número " . $this->infoClase->idClase . " y calificar al alumno " . $this->infoAlummno->nombreAluno . ".",
            "url" => "#",
            "color" => "bg-success",
            "icon" => '<i class="mdi mdi-book-clock"></i>' 
        ];
    }
}
