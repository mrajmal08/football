<?php

namespace App\Console\Commands;

use App\Helpers\FantasyPointsHelper;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerGame;
use App\Models\FantasyData\TeamGame;
use App\Models\FantasyPlayerGameFantasyPoint;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CalculateFantasyPlayerGameFantasyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CalculateFantasyPlayerGameFantasyPoints {--all} {--week=} {--year=} {--position=} {--isProjection}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fill fantasy teams points';

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
        $systemSettings = Helper::getSystemSettingsDetails();
        $weekPrompt = $this->option('week');
        $allPrompt = $this->option('all');
        $isProjection = $this->option('isProjection');
        $year = $this->option('year');
        $position = $this->option('position');

        if ($position) {
            $positionArray = [$position];
        } else {
            $positionArray = ['QB', 'RB', 'WR', 'TE', 'K', 'DEF', 'TQB', 'ST'];
        }

        try {
            $week = $systemSettings['week'];
            $season = $systemSettings['season'];
            $seasonType = $systemSettings['season_type'];

            $season = (! empty($year)) ? $year : $systemSettings['season'];

            //Set default to be current system settings week
            $weekStart = $systemSettings['week'];
            $weekLimit = $weekStart;

            //Now check for specific params that might be passed
            if ($weekPrompt > 0) {
                $weekStart = $weekPrompt;
                $weekLimit = $weekStart;
            }

            //Finally check for all
            if ($allPrompt) {
                $weekStart = 1;     //Start with week 1
                $weekLimit = 17;    //Go all the way to week 17
            }

            for ($week = $weekStart; $week <= $weekLimit; $week++) {
                $alertType = ($isProjection) ? ' Projections' : ' Real';
                $alertLine = class_basename(get_class($this)).$alertType.' |  Season: '.$season.' | SeasonType: '.$seasonType.' | Week: '.$week;
                $this->info($alertLine);

                //$fantasy_player = FantasyPlayer::get();
                FantasyPlayer::whereIn('position', $positionArray)->orderBy('id')->chunk(2, function ($fantasy_players) use ($week, $season, $seasonType, $isProjection) {
                    foreach ($fantasy_players as $list) {
                        //for Player Game FantasyPoint
                        //dd($list);
                        $points = FantasyPointsHelper::calculateFantasyPlayerGameFantasyPoints($week, $season, $seasonType, $list, $isProjection);
                        //if ($list->position == "QB")
                        //$this->info($list->position. " Season " .$season ." Wk ". $week. "  " . $list->name . " Pts: ". $points);
                    }
                    unset($fantasy_players);
                });
            }
            $this->info('Finished: '.$alertLine);
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
