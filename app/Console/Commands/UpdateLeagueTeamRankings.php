<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeagueGame;
use App\Models\LeagueGamesSim;
use App\Models\LeagueSchedule;
use App\Models\LeagueScheduleSim;
use App\Models\LeagueTeamRanking;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class UpdateLeagueTeamRankings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateLeagueTeamRankings {--league_id=} {--week=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create and update team rank ranking';

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
        $week = $this->option('week') ? $this->option('week') : $systemSettings['week'];
        $season = $systemSettings['season'];
        $season_type = 1; // Hard code to always be season type 1   //$systemSettings['season_type'];

        // Hackish to make sure we set the correct season type

        $league_id = $this->option('league_id');

        if ($league_id > 0) {
            $leagues = League::where('id', $league_id)->where('draft_completed', '1')->get();
        } else {
            $leagues = League::where('draft_completed', '1')->orderBy('id', 'DESC')->get();
        }

        try {
            $this->info('Update League Team Rankings | Week: '.$week.' | League: '.$league_id);

            if (! empty($leagues)) {
                foreach ($leagues  as $key=>$value) {
                    $this->info('ForeachLoop, League ID: '.$value->id);
                    $fantasy_teams = FantasyTeam::where('league_id', $value->id)->get();

                    if (! empty($fantasy_teams)) {
                        foreach ($fantasy_teams  as $fkey=>$fvalue) {
                            $result = Helper::getTeamRankUpToWeek($value->id, $fvalue->id, $week);
                            $tournament_rank = 0;
                            $tournament_pts = 0;
                            $teamrank = [];

                            // if ($week==17) {
                            //     $teamrank=Helper::getTeamRankForWeek17($value->id, $season, $fvalue->id);
                            //     $tournament_rank	=$teamrank['tournament_rank'];
                            //     $tournament_pts		=$teamrank['tournament_pts'];
                            //     dd($teamrank);
                            // }

                            //dd($result);

                            $win = $result['team_win_loss']['total_win'];
                            $loss = $result['team_win_loss']['total_loss'];
                            $tie = $result['team_win_loss']['total_tie'];
                            $sim_win = $result['teamSim_win_loss']['total_win'];
                            $sim_loss = $result['teamSim_win_loss']['total_loss'];
                            $sim_tie = $result['teamSim_win_loss']['total_tie'];
                            $sim_overall_pts = $result['sim_overall_pts'];
                            $coach_score = $result['coach_score'];
                            $head_to_head_pts = $result['team_scores']['head_to_head_pts'];
                            $points_against = $result['team_scores']['points_against'];
                            $points_for = $result['team_scores']['points_for'];
                            $points_for_pts = $result['team_scores']['points_for_pts'];
                            $tournament_rank = $result['team_scores']['tournament_rank'];
                            $tournament_pts = $result['team_scores']['tournament_pts'];

                            $sim_overall_rank = 0;

                            $data = [
                                'league_id'      	=> $value->id,
                                'fatasy_team_id' 	=> $fvalue->id,
                                'season' 			=> $season,
                                'season_type' 		=> $season_type,
                                'week' 				=> $week,
                                'is_finished' 		=> true,
                                'win' 				=> $win,
                                'loss' 				=> $loss,
                                'tie' 				=> $tie,
                                'head_to_head_pts' 	=> $head_to_head_pts,
                                'points_against' 	=> $points_against,
                                'points_for' 		=> $points_for,
                                'points_for_pts' 	=> $points_for_pts,
                                'sim_overall_win' 	=> $sim_win,
                                'sim_overall_loss' 	=> $sim_loss,
                                'sim_overall_tie' 	=> $sim_tie,
                                'sim_overall_pts' 	=> $sim_overall_pts,
                                'sim_overall_rank' 	=> $sim_overall_rank,
                                'tournament_rank' 	=> $tournament_rank,
                                'tournament_pts' 	=> $tournament_pts,
                                'coach_score' 		=> $coach_score,
                                'overall_coach_rank'=> 1,

                            ];

                            $model = LeagueTeamRanking::updateOrCreate(
                                ['season'   => $season, 'season_type'=> $season_type, 'week'=> $week, 'league_id'=>$value->id, 'fatasy_team_id'=>$fvalue->id],
                                $data
                            );
                        }

                        $leage_rank = LeagueTeamRanking::where('season', $season)->where('season_type', $season_type)->where('week', $week)
                                                                ->where('league_id', $value->id)->orderBy('coach_score', 'desc')->get()->toArray();

                        if (! empty($leage_rank)) {
                            $i = 1;
                            foreach ($leage_rank as $key=>$val) {
                                $leage_team_rank = LeagueTeamRanking::find($val['id']);
                                $leage_team_rank->overall_coach_rank = $i;
                                $leage_team_rank->save();
                                $i++;
                            }
                        }
                    }
                }

                $this->info('League team rankings have been updated successfully');
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
