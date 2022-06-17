<?php

namespace App\Console\Commands;

use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AdvanceWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AdvanceWeek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To automate moving to the next fantasy week.';

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
        // Get the current week in the system.
        $systemSettings = SystemSetting::find(1);
        $currentWeek = $systemSettings->week;

        // Make Sure Box Scores are Updated
        $this->call('UpdateBoxScores', ['--finished' => true]);

        if ($systemSettings->season_type != 3) {
            // Update League Games for the regular season
            $this->call('UpdateLeagueGames', ['--finished' => true]);
        }

        // If we are at the end of the REG Season then we need to do some different tasks.
        if ($currentWeek == 18 || $systemSettings->season_type == 3) {
            if ($currentWeek == 18 && $systemSettings->season_type == 1) {
                // Change for the upcoming switch if we are on the end of the season.
                $week = 1;
            } else {
                // Save the final scores from the week
                // Update League Postseason Scores
                $this->call('UpdateLeaguePostseasonScores');

                // Advance the week
                $week = $currentWeek + 1;
            }

            $systemSettings->week = $week;
            $systemSettings->season_type = 3;
            $systemSettings->save();

            $this->info('Week changed to '.$week);

            // Update NFL Schedules to get Playoff Games
            $this->call('UpdateSchedules');
        } else {
            $week = $currentWeek + 1;
            $systemSettings->week = $week;
            $systemSettings->save();

            $this->info('Week changed to '.$week);

            // Update the weekly position games for week 7
            if ($week < 8) {
                $this->call('GenerateLeagueSchedules', ['--week' => 7]);
            }

            // Update the weekly position games for week 15
            if ($week < 16) {
                $this->call('GenerateLeagueSchedules', ['--week' => 15]);
            }

            // Update the weekly position games for week 16, 17, 18
            if ($week == 16) {
                $this->call('GenerateLeagueSchedules', ['--week' => 16]);
            }
            if ($week == 17) {
                $this->call('GenerateLeagueSchedules', ['--week' => 17]);
            }
            if ($week == 18) {
                $this->call('GenerateLeagueSchedules', ['--week' => 18]);
            }

            // Update The League Games and Rosters so that current week roster is set
            $this->call('UpdateLeagueGames', ['--andRosters' => true]);

            // Set waivers to enabled.
            $systemSettings->waiver_period_enabled = 1;
            $systemSettings->save();
            $this->info('Waiver Period Enabled');
        }
    }
}
