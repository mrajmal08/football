<?php

namespace App\Notifications;

use App\Models\FantasyTeam;
use App\Models\League;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FantasyLeagueInvitation extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $token, $email)
    {
        $this->user = $user;
        $this->token = $token;
        $this->email = $email;
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
        $url = url('/register/'.$leagueDetails->invite_code.'?invite_token='.$this->token);

        return (new MailMessage)
                    ->subject('You have been invited to join '.$leagueDetails->name)
                    ->line($this->user->name.' has invited you to join the '.$leagueDetails->name.' League at ACME Real Fantasy Football.')
                    ->action('Accept Invitation', $url);
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
