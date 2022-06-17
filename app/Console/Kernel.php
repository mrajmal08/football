<?php

namespace App\Console;

use App\Models\DraftOrder;
use App\Models\FantasyTeam;
use App\Models\League;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Process\Process;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //'App\Console\Commands\UpdateBoxScores',
        // 'App\Console\Commands\ScheduleDraftOrder',
        // 'App\Console\Commands\ScheduleStartDraft',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $alertEmails = ['nogahawaii@gmail.com', 'thindery@gmail.com'];

        // Regular Laravel Maintenance
        // $schedule->command('telescope:prune')->daily()->emailOutputOnFailure($alertEmails);
        // END Regular Laravel Maintenance

        // USED AT BEGINNING OF SEASON
        // Schedule Drafts
        // $schedule->command('ScheduleDraftOrder')->everyMinute()->name('generate-draft-order')->emailOutputOnFailure($alertEmails);

        // WEEKLY API General Data
        // Per Sportsdata.io https://sportsdata.io/developers/implementation-guide

        $schedule->command('UpdateTimeframes')->daily(3)->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        $schedule->command('UpdateTeams')->daily('20:00')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        $schedule->command('UpdateSchedules')->hourly()->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        $schedule->command('UpdateStandings')->daily('20:00')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        $schedule->command('UpdateFantasyPlayers')->hourly()->emailOutputOnFailure($alertEmails);
        $schedule->command('UpdatePlayers')->hourly()->emailOutputOnFailure($alertEmails);
        $schedule->command('_UpdateProjections')->everyFourHours()->emailOutputOnFailure($alertEmails);
        $schedule->command('GetNews')->hourly()->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // All Player Season Stats (Syncing TQB/ST, and Calculate Fantasy Points)
        $schedule->command('UpdateStats')->daily('2:30')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // END WEEKLY API General Data

        // Advance to Next week Tuesday Mornings at 3am EST
        // 2 = Tuesday
        // 3 = Wednesday (Covid 19)
        // https://laravel.com/docs/7.x/scheduling
        $schedule->command('AdvanceWeek')->weeklyOn(3, '3:00')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // Process Waiver Wire
        // Wed Morning 3am
        $schedule->command('ProcessWaiverWire')->weeklyOn(4, '12:00')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // Send email alerts about FantasyTeam Issues
        // Thursday Night
        //$schedule->command('ValidateFantasyTeams')->weeklyOn(4, '11:45')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        $schedule->command('ValidateFantasyTeams')->weeklyOn(4, '18:30')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails, );

        // Saturday Afternoon 12:00pm Games
        // $schedule->command('ValidateFantasyTeams')->weeklyOn(7, '11:10')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(7, '11:55')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // Saturday Afternoon 3:30pm Games
        // $schedule->command('ValidateFantasyTeams')->weeklyOn(7, '14:30')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(7, '15:25')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // // Saturday Evening 7:15pm Games
        // $schedule->command('ValidateFantasyTeams')->weeklyOn(7, '18:25')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(1, '19:10')->timezone('America/Chicago')->emailOutputOnFailure($alertEmails);

        // Sunday 12pm Games
        $schedule->command('ValidateFantasyTeams')->weeklyOn(0, '12:10')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(0, '12:55')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Sunday Afternoon 3:05pm Games
        $schedule->command('ValidateFantasyTeams')->weeklyOn(0, '15:15')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(0, '16:00')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Sunday Afternoon 3:20pm Games
        $schedule->command('ValidateFantasyTeams')->weeklyOn(0, '15:30')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(0, '16:15')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Sunday Evening 7:20pm Games
        $schedule->command('ValidateFantasyTeams')->weeklyOn(0, '19:30')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(0, '20:15')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Monday Evening 7:15pm Games
        $schedule->command('ValidateFantasyTeams')->weeklyOn(1, '19:25')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(1, '20:10')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Tuesday Night Football 7:00pm Games
        // $schedule->command('ValidateFantasyTeams')->weeklyOn(2, '19:10')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(2, '19:55')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // Wednesday Football 3:40pm EST Games
        // $schedule->command('ValidateFantasyTeams')->weeklyOn(3, '14:50')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);
        // $schedule->command('ValidateFantasyTeams --commitTransaction')->weeklyOn(3, '15:35')->timezone('America/New_York')->emailOutputOnFailure($alertEmails);

        // LIVE GAME DATA
        // Box Scores
        // Run every minute from 7pm to 12 PM on Thursday...
        $schedule->command('UpdateBoxScores')
            ->thursdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('19:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 12pm to 12 AM on Saturday...
        $schedule->command('UpdateBoxScores')
            ->saturdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('18:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 12pm to 12 AM on Sunday...
        $schedule->command('UpdateBoxScores')
            ->sundays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('10:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 7pm to 12 PM on Monday...
        $schedule->command('UpdateBoxScores')
            ->mondays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('16:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 7pm to 12 PM on Tuesday...
        $schedule->command('UpdateBoxScores')
            ->tuesdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('16:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // END LIVE GAME DATA

        // UPDATE LEAGUE GAMES
        // Run every minute from 7pm to 12 PM on Thursday...
        $schedule->command('UpdateLeagueGames')
            ->thursdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('19:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 3:30pm to 12 AM on Saturday...
        $schedule->command('UpdateLeagueGames')
            ->saturdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('18:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 12pm to 12 PM on Sunday...
        $schedule->command('UpdateLeagueGames')
            ->sundays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('12:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 7pm to 12 AM on Monday...
        $schedule->command('UpdateLeagueGames')
            ->mondays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('19:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // Run every minute from 7pm to 12 AM on Tuesday...
        $schedule->command('UpdateLeagueGames')
            ->tuesdays()
            ->everyMinute()
            ->timezone('America/Chicago')
            ->between('19:00', '24:00')->withoutOverlapping()->emailOutputOnFailure($alertEmails);

        // END UPDATE LEAGUE GAMES
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
