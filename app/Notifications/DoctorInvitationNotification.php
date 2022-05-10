<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorInvitationNotification extends Notification
{
    use Queueable;

    protected string $notification_url;

    protected string $token;

    public function __construct(string $notification_url, string $token)
    {
        $this->notification_url = $notification_url;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Invitation to join the Healthcare App')
            ->priority(1)
            ->greeting('Greetings Doctor!')
            ->line('This is to invite you to join our platform ')
            ->line('Copy the token below and paste it in the registration form')
            ->line('Your token is: '.$this->token)
            ->action('Register', $this->notification_url)
            ->line('Thank you for using our application!')
            ->salutation('Regards, Healthcare App');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
