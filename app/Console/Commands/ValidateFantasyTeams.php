<?php

namespace App\Console\Commands;

use App\Jobs\ValidateFantasyTeamByWeek;
use App\Mail\SendStatusMail;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\Player;
use App\Models\FantasyData\Team;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Notifications\FantasyTeamNotValid;
use Helper;
use Illuminate\Console\Command;
use Mail;

class ValidateFantasyTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ValidateFantasyTeams {--teamId=} {--commitTransaction}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate FantasyTeams';

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
        //dd(phpinfo());
        $commitTransaction = $this->option('commitTransaction');
        $teamId = $this->option('teamId');
        $systemSettings = Helper::getSystemSettingsDetails();
        // $week				= $systemSettings['week'];
        // $season				= $systemSettings['season'];
        // $seasonType			= $systemSettings['season_type'];

        $bench_data_message = '';

        try {
            if ($teamId) {
                $fantasy_teams = FantasyTeam::where('id', $teamId)->get();

                if (! empty($fantasy_teams)) {
                    foreach ($fantasy_teams as $key => $team) {
                        ValidateFantasyTeamByWeek::dispatch($team, $commitTransaction);
                    }
                }
            } else {
                $leagues = League::all();
                foreach ($leagues as $lkey=>$lval) {
                    $fantasy_teams = FantasyTeam::where('league_id', $lval['id'])->get();
                    if (! empty($fantasy_teams)) {
                        foreach ($fantasy_teams as $key => $team) {
                            ValidateFantasyTeamByWeek::dispatch($team, $commitTransaction);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
