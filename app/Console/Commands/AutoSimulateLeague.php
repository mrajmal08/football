<?php

namespace App\Console\Commands;

use App\Models\League;
use Illuminate\Console\Command;

class AutoSimulateLeague extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * @start is what week to start out. i.e if it is week 5, You want to start at week 5.
     */
    protected $signature = 'AutoSimulateLeague {--league_id=} {--week=} {--start=0} {--finished}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To auto simulate leagues';

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
        $week = $this->option('week');
        $start = $this->option('start') > 0 ?: $week;        //If we don't specify the start then we sill sim just one week (whatever the user specifies)
        $league_id = $this->option('league_id');
        $finished = $this->option('finished');

        if ($week < 1) {
            die('Must input a week.');
        }

        $this->info('Start at week '.$start);
        $this->info('Week at week '.$week);
        //dd('done');

        for ($i = $start; $i <= $week; $i++) {
            if ($league_id > 0) {
                $leagues = League::where('id', $league_id)->get();
            } else {
                $leagues = League::orderBy('id', 'DESC')->get();
            }

            foreach ($leagues as $key=>$val) {
                echo '----Working on Week '.$i."----\r\n";

                //Set settings to the week
                $this->call('UpdateSystemSettings', ['--week' => $i]);

                //Update Projections
                //$this->call('_UpdateProjections', ['--week' => $i]);

                if ($i == 7 || $i == 14 || $i == 15 || $i == 16 || $i == 17) {
                    //Gemerate special week schedule based on previos data.
                    $this->call('GenerateLeagueSchedules', ['--league_id'=>$val->id, '--week' => $i]);
                }

                //Update Rosters and teams so you can actively watch in browser.
                $this->call('UpdateLeagueGames', ['--league_id'=>$val->id, '--finished' => '0']);

                $this->info('Get Box Scores');

                //Get the NFL games data for the week
                $this->call('UpdateBoxScores', ['--finished' => 1]);

                $this->call('UpdateLeagueGames', ['--league_id'=>$val->id, '--finished' => '0']);

                if ($finished) {
                    $this->call('UpdateLeagueGames', ['--league_id'=>$val->id, '--finished' => '1']);
                }
            }
        }
    }
}
