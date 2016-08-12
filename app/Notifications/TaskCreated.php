<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;

use App\Task;

class TaskCreated extends Notification
{
    use Queueable;

		public $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','nexmo'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
										->subject('Taak aangemaakt')
                    ->line($this->task->user_name.' heeft een nieuwe taak aangemaakt:')
										->line("<strong>".$this->task->title."</strong>")
                    ->action('Bekijk nu', 'http://'.env('APP_URL'));
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

		public function toNexmo($notifiable)
		{
			if (empty($notifiable->phone_number)) return null;

		    return (new NexmoMessage)
		                ->content($this->task->user_name.' heeft de taak "'.$this->task->title.'" aangemaakt');
		}
}
