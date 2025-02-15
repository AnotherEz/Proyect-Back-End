<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordCodeNotification extends Notification {
    use Queueable;
    protected $code;

    public function __construct($code) {
        $this->code = $code;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Código de Recuperación de Contraseña')
            ->greeting('¡Hola!')
            ->line('Has solicitado recuperar tu contraseña. Usa el siguiente código para continuar:')
            ->line('**Código: ' . $this->code . '**')
            ->line('Este código expira en 15 minutos.')
            ->line('Si no solicitaste este restablecimiento, ignora este correo.');
    }
}
