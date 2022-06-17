<?php

namespace App\Console\Commands;

use Helper;
use Illuminate\Console\Command;

class _UpdateProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * **Examples**
     *  _UpdateProjections --all --year=2018
     *
     * @var string
     */
    protected $signature = '_UpdateProjections {--all} {--week=0} {--weekEnd=0} {--year=} {--seasonTypeInt=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command unifies all projection commands under a singular command.';

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
        $weekPrompt = $this->option('week');
        $weekEnd = $this->option('weekEnd');
        $allPrompt = $this->option('all');
        $yearPrompt = $this->option('year');

        $systemSettings = Helper::getSystemSettingsDetails();
        $season = (! empty($yearPrompt)) ? $yearPrompt : $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];

        //Set default to be current system settings week
        $weekStart = $systemSettings['week'];
        $weekLimit = $weekStart;

        //Now check for specific params that might be passed
        if ($weekPrompt > 0) {
            $weekStart = $weekPrompt;
            $weekLimit = $weekStart;
        }
        if ($weekEnd > 0) {
            $weekLimit = $weekEnd;
        }

        //Finally check for all
        if ($allPrompt) {
            $weekStart = 1;     //Start with week 1
            if ($weekPrompt > 0) {
                $weekStart = $weekPrompt;
            }
            $weekLimit = 18;    //Go all the way to week 17
        }

        try {
            $this->call('CleanUpProjections');
            for ($week = $weekStart; $week <= $weekLimit; $week++) {
                $alertLine = class_basename(get_class($this)).' | Season: '.$season.' | Week: '.$week."\r\n";
                $this->info($alertLine);

                // Calculate Defense
                // Note: This command calculates fantasy points inside of it.
                $this->call('UpdateDefenseProjections', ['--week' => $week, '--year' => $season]);

                // Get QB, RB, WR, TE, K Projection Data
                // Note: These commands calculate fantasy points inside of them.
                $this->call('UpdatePlayerProjections', ['--week' => $week, '--season' => $season]);

                // Sync TQB and ST
                // Note: These commands calculate fantasy points inside of them.
                $this->call('SyncPositionGameData', ['--position' => 'TQB', '--week' => $week, '--season' => $season, '--isProjection' => 1]);
                $this->call('SyncPositionGameData', ['--position' => 'ST', '--week' => $week, '--season' => $season, '--isProjection' => 1]);
            }

            //Update the Season Data Models
            $this->call('UpdatePlayerSeasonProjections', []);       // NFL Individual Player Projected Season Statistitcs
            $this->call('UpdateDefenseSeasonProjections', []);      // NFL Defense Projected Season Statistitcs

            // Sync TQB & ST Season Data
            $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--season' => $season, '--seasonTypeInt' => $seasonType, '--isProjection' => 1]);
            $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--season' => $season, '--seasonTypeInt' => $seasonType, '--isProjection' => 1]);

            //Calculate ACME Points
            $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--year' => $season, '--isProjection' => true]);
        } catch (Exception $e) {
            $this->info('Exception when calling api: ', $e->getMessage(), PHP_EOL);
        }
        $this->info('Finished '.$alertLine);
    }
}
