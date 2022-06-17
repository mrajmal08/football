<?php

namespace App\Jobs;

use App\Models\League;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateDraftOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $league;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 150;

    /**
     * The queue connection that should handle the job.
     *
     * @var string
     */
    // public $connection = 'generatedraftorder';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($league)
    {
        $this->league = $league;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Artisan::call('GenerateDraftOrder', ['--league_id' => $this->league->id]);
    }
}
