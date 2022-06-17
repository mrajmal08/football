<?php

namespace App\Console\Commands;

use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateDraftOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateDraftOrder {--league_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To generate draft order';

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
        $league_id = $this->option('league_id');
        if ($league_id > 0) {
            $league = League::find($league_id);

            $current_draft = DraftOrder::where('fantasy_player_id', null)
              ->where('deadline', '<>', null)
              ->where('league_id', $league_id)
              ->first();

            if (! empty($league) && empty($current_draft)) {
                $this->info('Found League to generate: '.$league->name.' '.$league->draft_date);
                $league->draft_order_generated = 1;
                $league->save();
                sleep(2);
                $teams = FantasyTeam::where('league_id', $league->id)->orderBy('id', 'asc')->get();
                $random = $teams->shuffle();
                $random->all();
                $random = $random->toArray();
                $i = 0;
                $deadline = null;
                if (! empty($random)) {
                    $j = 1;
                    for ($i = 1; $i <= 9; $i++) {
                        if ($i % 2 == 0) {
                            $random = array_reverse($random);
                        } else {
                            $random = array_reverse($random);
                        }
                        $m = 1;
                        foreach ($random as $key=>$val) {
                            if ($i == 1) {
                                $team = FantasyTeam::where('id', $val['id'])->first();
                                $team->league_team_number = $m;
                                $team->save();
                                sleep(5); //Used to simulate a live draft reveal.
                            }
                            if ($j == 1) {
                                $dateTime = new \DateTime($league->draft_date);
                                $dateTime->modify('+'.$league->draft_pick_max_time.'seconds');
                                $deadline = $dateTime;
                            } else {
                                $deadline = null;
                            }

                            $draftOrder = DraftOrder::create([
                                'league_id' => $league->id,
                                'fantasy_team_id' => $val['id'],
                                'fantasy_player_id' => null,
                                'round' => $i,
                                'league_overall_pick' => $j,
                                'round_overall_pick' => $m,
                                'deadline' => $deadline,
                            ]);
                            $j++;
                            $m++;
                        }
                    }
                }

                // $league->draft_order_generated = 1;
                // $league->save();
                $this->info('Draft has been generated');
            } else {
                $this->error('No leagues found');
            }
        } else {
            $this->error('League id is required');
        }
    }
}
