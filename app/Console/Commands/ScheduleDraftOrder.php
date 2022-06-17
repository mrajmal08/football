<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDraftOrder;
use App\Jobs\StartLeagueDraft;
use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleDraftOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleDraftOrder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To run the Shedule DraftOrder and Start Draft';

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
            ->where('draft_order_generated', 0)
            ->where('draft_date', '<=', Carbon::now()->addMinutes(5))
            ->where('online_draft', 1)
            ->get();
        $this->info('Found '.count($leagues).' leagues that need to get draft orders');
        echo 'Found '.count($leagues).' leagues that need to get draft orders';

        if (! empty($leagues)) {
            foreach ($leagues as $league) {
                if ($league->teams->count() < 12) {
                    continue;
                }
                // $this->info('League Generate Draft Order: '. $league->name .' '.$league->draft_date);

                // Start the computer draft process at the specific draft date and time
                $dt = new \DateTime($league->draft_date); // <== instance from another API
                $carbon = Carbon::instance($dt);
                //echo get_class($carbon);                               // 'Carbon\Carbon'
                //echo $carbon->toDateTimeString();
                //dd($carbon);
                StartLeagueDraft::dispatch($league)->onQueue('draftprocess_queue')->delay($carbon);

                // Generate the draft order now.
                GenerateDraftOrder::dispatch($league)->onQueue('generatedraftorder_queue');

                // $delayDate = $ldate->copy()->subMinutes(5);
                // GenerateDraftOrder::dispatch($league)->onQueue('generatedraftorder_queue')->delay($delayDate);

                //\Artisan::queue('GenerateDraftOrder', ['--league_id' => $league->id])->onQueue('generatedraftorder_queue')->setTimeout(80);
                //$this->call('GenerateDraftOrder', ['--league_id' => $league->id]);
            }
        }
    }
}
