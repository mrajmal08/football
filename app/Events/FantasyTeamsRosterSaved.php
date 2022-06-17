<?php

namespace App\Events;

use App\Models\FantasyTeamsRoster;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FantasyTeamsRosterSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FantasyTeamsRoster $fantasyTeamRoster)
    {
        $this->transaction = $fantasyTeamRoster;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on a channel for the specific league id. This will allow all users to receive the event.
        return new PrivateChannel('league.'.$this->transaction->league_id);
    }

    public function broadcastAs()
    {
        return 'league.transaction';
    }
}
