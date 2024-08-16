<?php

namespace App\Notifications\Tasks;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly ?Task $task)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject(sprintf("Update task %s", $this->task->title))
                    ->line(sprintf('Task %s has changed', $this->task->title))
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toTelegram(object $notifiable): TelegramMessage
    {
        return TelegramMessage::create()
        ->to('-4282839087')
        ->content("Task has been updated!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
