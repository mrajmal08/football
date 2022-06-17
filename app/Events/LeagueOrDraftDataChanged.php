<?php

namespace App\Events;

use App\Jobs\GenerateDraftOrder;
use App\Jobs\StartLeagueDraft;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Redis;

class LeagueOrDraftDataChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $league;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(League $league)
    {
        // We no longer schedule the queued jobs this way.
        $this->league = $league;
        // return;

        // if the data changed for the draft we need to schedule the job
        // Start the Generate Draft Order command (for now) 5 minutes before
        if (! $league->draft_order_generated && $ldate = $league->draft_date) {
            // Look up past jobs and cancel them.
            // $thejobs = array();

            // // Get the number of jobs on the queue
            // $numJobs = Redis::connection()->llen('queues:generatedraftorder_queue:delayed');

            // // Here we select details for up to 1000 jobs
            // $jobs = Redis::connection()->lrange('queues:generatedraftorder_queue:delayed', 0, 1000);

            // // I wanted to clean up the data a bit
            // // you could use var_dump to see what it looks like before this
            // // var_dump($jobs);
            // foreach ($jobs as $job) {

            //     // Each job here is in json format so decode to object form
            //     $tmpdata = json_decode($job);
            //     $data = $tmpdata->data;

            //     // I wanted to just get the command so I stripped away App\Jobs at the start
            //     $command = $this->get_string_between($data->command, '"App\Jobs\\', '"');
            //     $id = $tmpdata->id;

            //     // Could be good to see the number of attempts
            //     $attempts = $tmpdata->attempts;
            //     $thejobs[] = array($command, $id, $attempts);
            // }
            // $pastJobs = \Queue::getRedis()->connection('default')->zrange('queues:generatedraftorder_queue:delayed' ,0, -1);

            // $delayDate = $ldate->copy()->subMinutes(5);
            // GenerateDraftOrder::dispatch($league)->onQueue('generatedraftorder_queue')->delay($delayDate);

            // // Start the computer draft process at the specific draft date and time
            // StartLeagueDraft::dispatch($league)->onQueue('draftprocess_queue')->delay($league->draft_date);
        }
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
