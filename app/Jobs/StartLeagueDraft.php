<?php

namespace App\Jobs;

use App\Models\League;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartLeagueDraft implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $league;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 108;

    /**
     * The number of seconds the job can run before timing out.
     *
     * 3240 = 30 seconds for 108 picks
     * @var int
     */
    public $timeout = 3240;

    /**
     * The queue connection that should handle the job.
     *
     * @var string
     */
    // public $connection = 'generatedraftorder';

    /**
     * Create a new job instance.
     * Set the timeout to be equal to the draft_pick_max time for 120 picks.
     * @return void
     */
    public function __construct(League $league)
    {
        $this->league = $league;
        $this->timeout = $league->draft_pick_max_time * 120;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Artisan::call('StartDraft', ['--league_id' => $this->league->id]);
    }
}
