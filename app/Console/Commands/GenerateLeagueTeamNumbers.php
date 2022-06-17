<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use Illuminate\Console\Command;

class GenerateLeagueTeamNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateLeagueTeamNumbers {--league_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate league team number';

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
            $teams = FantasyTeam::where('league_id', $league_id)->orderBy('id', 'asc')->get();
            if (count($teams) > 0) {
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
                            }
                            $j++;
                            $m++;
                        }
                    }
                    $this->info('league team number has been generated.');
                }
            } else {
                $this->info('No team found.');
            }
        } else {
            $this->error('league id is required.');
        }
    }
}
