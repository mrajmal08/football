<?php

namespace App\Events;

use App\Models\DraftOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DraftOrderChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $draftOrder;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DraftOrder $draftOrder)
    {
        $this->draftOrder = $draftOrder->load('fantasyPlayer', 'fantasyTeam');
        //dd($this->draftOrder);
        //Log::channel('slack_log')->error("Draft Order ". $this->draftOrder);
        //dd($this->draftOrder);
    }

    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'draftorderchange_queue';

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // Broadcast on a channel for the specific league id. This will allow all users to receive the event.
        return new PrivateChannel('league.'.$this->draftOrder->league_id);
    }

    public function broadcastAs()
    {
        // TODO Broadcast as specific type?
        // league.draftPick
        // league.onClock ?
        return 'league.draftPick';
    }
}
