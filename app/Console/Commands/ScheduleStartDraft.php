<?php

namespace App\Console\Commands;

use App\Jobs\StartLeagueDraft;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Console\Command;

// use App\Models\FantasyTeam;
// use App\Models\DraftOrder;

class ScheduleStartDraft extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleStartDraft';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Start a worker for each leagues draft.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $leagues = League::where('draft_date', '<>', null)
            ->where('draft_started', 0)
            ->where('draft_order_generated', 1)
            ->where('draft_date', '<=', Carbon::now()->addSeconds(70))   //Set the league to start within 15 seconds of the draft date
            //->whereBetween('draft_date', [now()->subSeconds(90), now()])
            ->where('online_draft', 1)
            ->get();

        if (! empty($leagues)) {
            foreach ($leagues as $league) {
                // Start up the worker
                StartLeagueDraft::dispatch($league)->onQueue('draftprocess_queue')->delay($league->draft_date);
                //\Artisan::queue('StartDraft', ['--league_id' => $league->id])->onQueue('draftprocess_queue');
                //$this->call('StartDraft', ['--league_id' => $league->id]);
            }
        }
    }
}
