<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Laravel\Spark\Notifications\SparkChannel;
use Laravel\Spark\Notifications\SparkNotification;

class FantasyTeamNotValid extends Notification
{
    use Queueable;

    public $mail_content;

    public $mail_content2;

    public $mail_content3;

    public $subject;

    public $greeting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $message2)
    {
        $this->mail_content = $message;
        $this->mail_content2 = $message2;
        $this->mail_content3 = ! strpos($message, 'automatically') ? 'Set a valid fantasy team roster for this week!' : '';
        $this->subject = ! strpos($message, 'automatically') ? 'Get your team ready for this week!' : 'There was a change made to your team';
        $this->greeting = ! strpos($message, 'automatically') ? 'There is an issue with your team!' : 'This was done automatically.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SparkChannel::class, 'mail'];
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
       ->subject($this->subject)
       ->greeting($this->greeting)
        ->line(new HtmlString($this->mail_content))
        ->line(new HtmlString($this->mail_content2))
        ->line(new HtmlString($this->mail_content3))
       ->action('View Roster', url('/team/roster'));
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

    public function toSpark($notifiable)
    {
        return (new SparkNotification)
              ->action('View Roster', url('/team/roster'))
              ->icon('fa-users')
              ->body($this->mail_content.'
				   Set a valid fantasy team roster for this week!');
    }
}
