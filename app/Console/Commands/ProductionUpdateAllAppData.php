<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Helper;
use Illuminate\Console\Command;

class ProductionUpdateAllAppData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProductionUpdateAllAppData {--years=1} {--history} {--hyear=}';

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
        \DB::disableQueryLog();

        $years = $this->option('years');
        $historyOnly = $this->option('history');
        $seasonTypeArray = Helper::getSystemSettingsDetails();
        $startYear = $seasonTypeArray['season'];
        $historyStart = $startYear - $years;

        $starttime = Carbon::now();
        $this->info('Start time: '.$starttime->toDateTimeString());

        if (! $historyOnly) {
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

            // Update TQB Draft position
            $this->call('SyncTqbAverageDraftPosition');

            // Game Projections for current year.
            // Disabled because it takes a LONG TIME.
            // $this->call('_UpdateProjections', ['--all' => 'all','--year' => $startYear]);       // ALL GAME PROJECTIONS FOR THE YEAR
        }

        if ($historyOnly) {
            $specificYear = $this->option('hyear');

            if ($specificYear) {
                $historyStart = $specificYear;
                $startYear = $specificYear + 1;
            }
        }

        while ($historyStart < $startYear) {
            $this->info('Updating Data for the year: '.$historyStart);

            // Update Past NFL Game Data for previous season
            // This also calculated fantasy points for the individual games
            $this->call('UpdateBoxScores', ['--finished' => 1, '--all' => 'all', '--year' => $historyStart]);  // All Weeks | $historyStart Year

            //Real Player Data
            $this->call('UpdatePlayerSeasonStats', ['--year' => $historyStart]);             // NFL Individual Player Real Season Statistitcs
            $this->call('UpdateTeamSeasonStats', ['--year' => $historyStart]);               // NFL Team Real Season Statistitcs
            $this->call('UpdateFantasyDefenseSeasonStats', ['--year' => $historyStart]);     // NFL Defense Real Season Statistitcs

            // // Sync Season Data
            $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--season' => $historyStart]);
            $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--season' => $historyStart]);

            //Get the season total
            $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--year' => $historyStart]);
            $historyStart++;
        }
        $endtime = Carbon::now();
        $this->info('Start time: '.$starttime->toDateTimeString());
        $this->info('End time: '.$endtime->toDateTimeString());
        $totalDuration = $endtime->diffInSeconds($starttime);
        $this->info(gmdate('H:i:s', $totalDuration));
    }
}
