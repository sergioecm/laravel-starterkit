<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class AlreadyHaveAccount extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(__('New Registration Attempt with Your Email Address'))
            ->line(__('You are receiving this email because we received a registration request with your registered email address.'))
            ->action('Login Instead', route('login'))
            ->line(Lang::get('If you did not try to register a new account, no further action is required.'));
    }
}

