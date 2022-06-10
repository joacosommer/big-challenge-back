<?php

namespace App\Notifications;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrescriptionUploadNotification extends Notification
{
    use Queueable;

    protected Submission $submission;

    protected string $notification_url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $notification_url, Submission $submission)
    {
        $this->notification_url = $notification_url;
        $this->submission = $submission;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /** @var User $doctor */
        $doctor = $this->submission->doctor;

        return (new MailMessage)
            ->subject('Prescription Uploaded')
            ->priority(1)
            ->greeting('Greetings Patient!')
            ->line('This is to notify you that your prescription has been uploaded by Dr.' . $doctor->last_name)
            ->line('Download the prescription from the link below:')
            ->action('Download prescription', $this->notification_url)
            ->line('Thank you for using our application!')
            ->salutation('Regards, Healthcare App');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
