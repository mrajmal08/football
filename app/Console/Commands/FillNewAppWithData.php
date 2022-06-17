<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class FillNewAppWithData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FillNewAppWithData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Helper artisan command to load all data for initial app.';

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
        $starttime = Carbon::now();
        echo 'Start time: '.$starttime->toDateTimeString()."\r\n";
        //Game and General Data
        $this->call('UpdateTeams', []);                         // NFL Team Data
        $this->call('UpdateTimeframes', []);                    // NFL Games
        $this->call('UpdateStandings', []);                     // NFL Standings
        $this->call('UpdateSchedules', []);                     // NFL Schedules

        //All Fantasy Players
        $this->call('UpdateFantasyPlayers', []);                // Fantasy Player Data
        $this->call('UpdatePlayers', []);                       // Individual Player Data

        //Get News for the app
        $this->call('GetNews', []);                       // News Records

        //Real Player Data
        $this->call('UpdatePlayerSeasonStats', []);             // NFL Individual Player Real Season Statistitcs
        $this->call('UpdateTeamSeasonStats', []);               // NFL Team Real Season Statistitcs
        $this->call('UpdateFantasyDefenseSeasonStats', []);     // NFL Defense Real Season Statistitcs

        //Update Past NFL Game Data for previous season
        $this->call('UpdateBoxScoresFinishedGames', ['--all' => 'all', '--year' => '2016']);  // All Weeks | 2016 Year
        $this->call('UpdateBoxScoresFinishedGames', ['--all' => 'all', '--year' => '2017']);  // All Weeks | 2017 Year
        $this->call('UpdateBoxScoresFinishedGames', ['--all' => 'all', '--year' => '2018']);  // All Weeks | 2018 Year
        //$this->call('UpdateBoxScoresFinishedGames', ['--all' => 'all','--year' => '2019']);  // All Weeks | 2018 Year

        //Generate TQB Real Life Game Data For Past Years
        $this->call('SyncPositionGameData', ['--position' => 'TQB', '--season' => '2016', '--seasonTypeInt' => 1, '--all' => true]);    //2016 Year
        $this->call('SyncPositionGameData', ['--position' => 'TQB', '--season' => '2017', '--seasonTypeInt' => 1, '--all' => true]);    //2017 Year
        $this->call('SyncPositionGameData', ['--position' => 'TQB', '--season' => '2018', '--seasonTypeInt' => 1, '--all' => true]);    //2018 Year

        //'SyncPositionSeasonData {--position=} {--season=} {--seasonTypeInt=} {--isProjection}';
        //Generate TQB Real Life Season Data
        $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--season' => '2016', '--seasonTypeInt' => 1]);    //2016 Year
        $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--season' => '2017', '--seasonTypeInt' => 1]);    //2017 Year
        $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--season' => '2018', '--seasonTypeInt' => 1]);    //2018 Year

        //Generate ST Real Life Game Data For Past Years
        $this->call('SyncPositionGameData', ['--position' => 'ST', '--season' => '2016', '--seasonTypeInt' => 1, '--all' => true]);    //2016 Year
        $this->call('SyncPositionGameData', ['--position' => 'ST', '--season' => '2017', '--seasonTypeInt' => 1, '--all' => true]);    //2017 Year
        $this->call('SyncPositionGameData', ['--position' => 'ST', '--season' => '2018', '--seasonTypeInt' => 1, '--all' => true]);    //2018 Year

        //Generate ST Real Life Season Data
        $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--season' => '2016', '--seasonTypeInt' => 1]);    //2016 Year
        $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--season' => '2017', '--seasonTypeInt' => 1]);    //2017 Year
        $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--season' => '2018', '--seasonTypeInt' => 1]);    //2018 Year

        //Calculate real game fantasy_points_acme data values for last year
        $this->call('CalculateFantasyPlayerGameFantasyPoints', ['--year' => 2016]);
        $this->call('CalculateFantasyPlayerGameFantasyPoints', ['--year' => 2017]);
        $this->call('CalculateFantasyPlayerGameFantasyPoints', ['--year' => 2018]);

        //Get the seasn total
        $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--year' => 2016]);
        $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--year' => 2017]);
        $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--year' => 2018]);

        //Game Projections for current year.
        $this->call('_UpdateProjections', ['--all' => 'all', '--year' => '2019', '--seasonTypeInt' => 1]);       // ALL GAME PROJECTIONS FOR THE YEAR

        $endtime = Carbon::now();
        echo 'Start time: '.$starttime->toDateTimeString()."\r\n";
        echo 'End time: '.$endtime->toDateTimeString()."\r\n";
        $totalDuration = $endtime->diffInSeconds($starttime);
        echo gmdate('H:i:s', $totalDuration);
    }
}
