<?php

namespace App\Notifications;

use App\Models\FantasyTeam;
use App\Models\League;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeToFantasyLeague extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
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
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $team = FantasyTeam::where('user_id', $this->user->id)->first();
        $leagueDetails = League::where('id', $team->league_id)->first();

        return (new MailMessage)
                    ->subject('Welcome to '.$leagueDetails->name)
                    ->line($this->user->name.', we are excited for the upcoming '.$leagueDetails->season.' fantasy football season! Visit your league home for the latest news.')
                    ->action('Click here', url('/league/home'));
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
