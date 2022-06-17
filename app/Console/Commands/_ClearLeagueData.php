<?php

namespace App\Console\Commands;

use App\Models\DraftOrder;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\League;
use App\Models\LeagueGame;
use App\Models\LeagueGamesSim;
use App\Models\LeaguePostseasonScores;
use App\Models\LeagueSchedule;
use App\Models\LeagueScheduleSim;
use App\Models\LeagueTeamRanking;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class _ClearLeagueData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '_ClearLeagueData {--league=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear league Data';

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
        $league_id = $this->option('league');

        //Delete records from draft_order table
        if ($league_id) {
            $draft_order = DraftOrder::where('league_id', $league_id)->delete();
        } else {
            $draft_order = DraftOrder::whereNotnull('id')->delete();
        }

        //Delete records from fantasy_teams_player_transactions table
        if ($league_id) {
            $fantasy_transaction = FantasyTeamsPlayerTransaction::where('league_id', $league_id)->delete();
        } else {
            $fantasy_transaction = FantasyTeamsPlayerTransaction::whereNotnull('id')->delete();
        }

        //Delete records from fantasy_teams_roster table
        if ($league_id) {
            $fantasy_roster = FantasyTeamsRoster::where('league_id', $league_id)->delete();
        } else {
            $fantasy_roster = FantasyTeamsRoster::whereNotnull('id')->delete();
        }

        //Delete records from league_postseason_scores table
        if ($league_id) {
            $league_post_season_score = LeaguePostseasonScores::where('league_id', $league_id)->delete();
        } else {
            $league_post_season_score = LeaguePostseasonScores::whereNotnull('id')->delete();
        }

        //Delete records from league_schedule_sims table
        if ($league_id) {
            $league_schedule_sims = LeagueScheduleSim::where('league_id', $league_id)->delete();
        } else {
            $league_schedule_sims = LeagueScheduleSim::whereNotnull('id')->delete();
        }
        //Delete records from league_team_rankings table
        if ($league_id) {
            $league_team_rankings = LeagueTeamRanking::where('league_id', $league_id)->delete();
        } else {
            $league_team_rankings = LeagueTeamRanking::whereNotnull('id')->delete();
        }

        //set all records in the leagues table so that
        //$cur_date		=	Carbon::now()->add('20', 'minute')->format('Y-m-d H:i');
        $cur_date = null;
        if ($league_id) {
            League::where('id', $league_id)->update([
                'draft_completed' => 0,
                'draft_order_generated' => 0,
                'draft_started' => 0,
                'draft_date' => $cur_date,
                'draft_pick_max_time' => 15,
            ]);
        } else {
            League::whereNotnull('id')->update([
                'draft_completed' => 0,
                'draft_order_generated' => 0,
                'draft_started' => 0,
                'draft_date' => $cur_date,
            ]);
        }

        //Delete records from league_schedule table
        if ($league_id) {
            $league_schedule = LeagueSchedule::where('league_id', $league_id)->get();
            if (! empty($league_schedule)) {
                foreach ($league_schedule as $list) {
                    $league_game = LeagueGame::where('league_schedule_id', $list->id)->delete();
                    $league_game_sim = LeagueGamesSim::where('league_schedule_id', $list->id)->delete();
                }
                $league_schedule = LeagueSchedule::where('league_id', $league_id)->delete();
            }
        } else {
            //Delete records from league_games_sims table
            $league_game_sim = LeagueGamesSim::whereNotnull('id')->delete();
            //Delete records from league_games table
            $league_game = LeagueGame::whereNotnull('id')->delete();
            $league_schedule = LeagueSchedule::whereNotnull('id')->delete();
        }

        $this->call('UpdateSystemSettings', ['--week' => 1]);
        echo "next commands you might need: \r\n\r\nphp artisan GenerateDraftOrder --league_id=".$league_id."\r\n\r\n";
        echo 'php artisan StartDraft --league_id='.$league_id."\r\n\r\n";
    }
}
