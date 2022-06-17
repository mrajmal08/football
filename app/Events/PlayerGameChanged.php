<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\FantasyData\PlayerGame;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Redis;

use App\Jobs\CalculateAcmeFantasyPointsByGame;

class PlayerGameChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $playerGame;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PlayerGame $playerGame, $isProjection
    {
        $this->playerGame = $playerGame;

        CalculateAcmeFantasyPointsByGame::dispatch($league)->onQueue('generatedraftorder_queue')->delay($delayDate);
    }

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'leaguedatachange_queue';

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on a channel for the specific league id. This will allow all users to receive the event.
        return new PrivateChannel('league.'.$this->league->id);
    }

    public function broadcastAs()
    {
        // TODO Broadcast as specific type?
        // league.draftPick
        // league.onClock ?
        return 'league.leagueOrDraftDataChanged';
    }
}
