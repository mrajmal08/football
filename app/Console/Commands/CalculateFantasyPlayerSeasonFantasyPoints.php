<?php

namespace App\Console\Commands;

use App\Helpers\FantasyPointsHelper;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\PlayerGame;
use App\Models\FantasyData\TeamGame;
use App\Models\FantasyPlayerSeasonFantasyPoint;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class CalculateFantasyPlayerSeasonFantasyPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CalculateFantasyPlayerSeasonFantasyPoints {--year=} {--seasonTypeInt=1} {--isProjection}  {{--position=}}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fill fantasy teams season points';

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
        $isProjection = $this->option('isProjection');
        $year = $this->option('year');
        $seasonTypeInt = $this->option('seasonTypeInt');
        $position = $this->option('position');

        $positionArray = ($position) ? [$position] : ['RB', 'WR', 'QB', 'TQB', 'TE', 'K', 'ST', 'DEF'];

        $systemSettings = Helper::getSystemSettingsDetails();

        try {
            $year = $year ?? $systemSettings['season'];
            $seasonTypeInt = ($seasonTypeInt) ?? $systemSettings['season_type'];
            $alertType = ($isProjection) ? ' Projections' : ' Real';
            $alertLine = class_basename(get_class($this)).$alertType.' |  Season: '.$year;

            $this->info($alertLine);

            // Get all fantasy players by 2's and start processing them.
            //$fantasyPlayers = FantasyPlayer::whereNotNull('team')->whereIn('position', $positionArray)->get();

            FantasyPlayer::whereNotNull('team')->whereIn('position', $positionArray)->orderBy('id')->chunk(2, function ($fantasyPlayers) use ($year, $seasonTypeInt, $isProjection) {
                foreach ($fantasyPlayers as $fantasyPlayer) {
                    $points = FantasyPointsHelper::calculateFantasyPlayerSeasonFantasyPoints($year, $seasonTypeInt, $fantasyPlayer, $isProjection);
                    //$this->info("Season ". $year. " " . $fantasyPlayer->name . ": ". $points);
                }
                unset($fantasyPlayers);
            });
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
        $this->info('Finished: '.$alertLine);
    }
}
