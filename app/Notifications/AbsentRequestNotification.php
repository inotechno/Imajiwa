<?php

namespace App\Notifications;

use App\Models\AbsentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsentRequestNotification extends Notification
{
    use Queueable;
    protected $absentRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(AbsentRequest $absentRequest)
    {
        $this->absentRequest = $absentRequest;
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
            'message' => 'An absent request has been submitted by ' . $this->absentRequest->employee->user->name,
            'url' => route('absent-requests.show', $this->absentRequest->id),
            'absent_request_id' => $this->absentRequest->id,
        ];
    }
}
