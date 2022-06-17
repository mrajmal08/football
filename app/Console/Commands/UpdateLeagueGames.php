<?php

namespace App\Console\Commands;

use App\Models\League;
use App\Models\LeagueGame;
use App\Models\LeagueGamesSim;
use App\Models\LeagueSchedule;
use App\Models\LeagueScheduleSim;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class UpdateLeagueGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateLeagueGames  {--league_id=} {--finished} {--andRosters} {--week=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update league games';

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
        $finished = $this->option('finished');
        $league_id = $this->option('league_id');
        $andRosters = $this->option('andRosters');

        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $this->option('week') ? $this->option('week') : $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];

        //\DB::enableQueryLog();
        if ($league_id) {
            $leagueSchedules = LeagueSchedule::where('league_id', $league_id)->where('week', $week)->where('year', $season)->where('game_type_id', $seasonType)->get();
        } else {
            $leagueSchedules = LeagueSchedule::where('week', $week)->where('year', $season)->where('game_type_id', $seasonType)->orderBy('id')->get();
        }

        //dd(\DB::getQueryLog()); // Show results of log

        try {
            $this->info('UpdateLeagueGames | Week: '.$week);
            $this->info('Have '.count($leagueSchedules).' games to update.');
            // $this->info('league_id '. $league_id);
            // $this->info('Week '. $week);
            // $this->info('season '. $season);
            // $this->info('seasonType '. $seasonType);

            if (! empty($leagueSchedules)) {
                //Update team rosters for week
                if ($andRosters) {
                    if ($this->option('week') && ($this->option('week') != $systemSettings['week'])) {
                        dd('Cannot Set Rosters for past weeks. Cannot Run.');
                    }

                    $this->info('UpdateRosters | Week: '.$week);
                    if ($league_id > 0) {
                        $this->call('FillFantasyTeamsRoster', ['--league_id' => $league_id]);
                    } else {
                        $leagues = League::get();

                        if (! empty($leagues)) {
                            foreach ($leagues  as $list) {
                                //sleep(2);
                                $this->call('FillFantasyTeamsRoster', ['--league_id' => $list->id]);
                            }
                        }
                    }
                }

                foreach ($leagueSchedules  as $key=>$value) {
                    $this->info('Calculating scores..');
                    $this->handleGameLogic($value, $season, $seasonType, $week, $finished, $isSim = false);
                }
                $this->info('League game details has been updated successfully for week '.$week);
            } else {
                $this->info('No league game details available for week '.$week);
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }

        if ($finished) {
            if ($league_id) {
                $leagueSchedulessim = LeagueScheduleSim::where('league_id', $league_id)->where('week', $week)->where('year', $season)->where('game_type_id', $seasonType)->get();
            } else {
                $leagueSchedulessim = LeagueScheduleSim::where('week', $week)->where('year', $season)->where('game_type_id', $seasonType)->get();
            }

            try {
//                $leagueSchedulessim	= LeagueScheduleSim::where('league_id', $league_id)->where('week', $week)->where('year', $season)->where('game_type_id', $seasonType)->get();

                if (! empty($leagueSchedulessim)) {

                        //Update team rosters for week
                    //$this->call('FillFantasyTeamsRoster', ['--league_id' => $league_id]);

                    foreach ($leagueSchedulessim  as $key=>$value) {
                        $this->info('Calculating sim scores..');
                        $this->handleGameLogic($value, $season, $seasonType, $week, $finished, $isSim = true);
                    }
                    $this->info('League game sim details has been updated successfully for week '.$week);
                    $this->call('UpdateLeagueTeamRankings', ['--league_id' => $league_id, '--week' => $week]);
                } else {
                    $this->info('No league game sim details available for week '.$week);
                }
            } catch (Exception $e) {
                echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
            }
        }
    }

    private function handleGameLogic($value, $season, $seasonType, $week, $finished, $isSim = false)
    {
        $team_score_result = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $value->home_team_id, true);
        $team_score = $this->getFantasyScore($team_score_result);

        $opponent_score_result = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $value->away_team_id, true);
        $opponent_score = $this->getFantasyScore($opponent_score_result);

        $winH = $lossH = $tieH = 0;		//home
                        $winA = $lossA = $tieA = 0;		//away

                        if ($finished) {
                            if ($team_score > $opponent_score) {
                                $winH = 1;
                                $lossA = 1;
                            }
                            if ($team_score < $opponent_score) {
                                $lossH = 1;
                                $winA = 1;
                            }
                            if ($team_score == $opponent_score) {
                                $tieH = 1;
                                $tieA = 1;
                            }
                        }
        $home_data = [
            'league_schedule_id'=> $value->id,
            'team_id' 			=> $value->home_team_id,
            'opponent_id' 		=> $value->away_team_id,
            'away_team_id' 		=> $value->away_team_id,
            'home_team_id' 		=> $value->home_team_id,
            'team_score' 		=> $team_score,
            'opponent_score' 	=> $opponent_score,
            'win' 				=> $winH,
            'loss' 				=> $lossH,
            'tie' 				=> $tieH,
            'year' 				=> $value->year,
            'week' 				=> $value->week,
            'game_type_id' 		=> $value->game_type_id,
            'is_finished' 		=> $finished,
        ];

        $away_data = [
            'league_schedule_id'=> $value->id,
            'team_id' 			=> $value->away_team_id,
            'opponent_id' 		=> $value->home_team_id,
            'away_team_id' 		=> $value->away_team_id,
            'home_team_id' 		=> $value->home_team_id,
            'team_score' 		=> $opponent_score,				//because we are saving the "away_data" away is considered the "opponent"
            'opponent_score' 	=> $team_score,					//because we are saving the "away_data" away is considered the "opponent"
            'win' 				=> $winA,
            'loss' 				=> $lossA,
            'tie' 				=> $tieA,
            'year' 				=> $value->year,
            'week' 				=> $value->week,
            'game_type_id' 		=> $value->game_type_id,
            'is_finished' 		=> $finished,
        ];

        if ($isSim) {
            //Home Team
            LeagueGamesSim::updateOrCreate(
                ['year'   => $value->year, 'week'=> $value->week, 'game_type_id'=> $value->game_type_id, 'team_id'=>$value->home_team_id, 'home_team_id'=>$value->home_team_id, 'away_team_id'=>$value->away_team_id],
                $home_data
            );

        // //Away Team
                                            // 							LeagueGamesSim::updateOrCreate(
                                            // 	['year'   => $value->year,'week'=> $value->week,'game_type_id'=> $value->game_type_id,'team_id'=>$value->away_team_id,'home_team_id'=>$value->home_team_id,'away_team_id'=>$value->away_team_id],
                                            // 	$away_data
                                            // );
        } else {
            if (! in_array($value->week, [15, 16, 17])) {
                LeagueGame::updateOrCreate(
                    ['year'   => $value->year, 'week'=> $value->week, 'game_type_id'=> $value->game_type_id, 'team_id'=>$value->home_team_id],
                    $home_data
                );

                LeagueGame::updateOrCreate(
                    ['year'   => $value->year, 'week'=> $value->week, 'game_type_id'=> $value->game_type_id, 'team_id'=>$value->away_team_id],
                    $away_data
                );
            } else {
                LeagueGame::updateOrCreate(
                    ['year'   => $value->year, 'week'=> $value->week, 'team_id'=>$value->home_team_id, 'home_team_id'=> $value->home_team_id, 'away_team_id'=>$value->away_team_id, 'game_type_id'=> $value->game_type_id],
                    $home_data
                );
                LeagueGame::updateOrCreate(
                    ['year'   => $value->year, 'week'=> $value->week, 'team_id'=>$value->away_team_id, 'home_team_id'=> $value->home_team_id, 'away_team_id'=>$value->away_team_id, 'game_type_id'=> $value->game_type_id],
                    $away_data
                );
            }
        }
    }

    private function getFantasyScore($fantasy_roster_data)
    {
        $fantasy_score = 0;
        $fantasyTeams = [];

        if (! empty($fantasy_roster_data->FantasyTeamRoster)) {
            foreach ($fantasy_roster_data->FantasyTeamRoster as $list) {
                $point = [];
                $playerPoints = 0;

                if ($list->fantasyPlayer->playerGame && $list->active) {
                    $point = $list->fantasyPlayer->playerGame;
                    $playerPoints = isset($point[0]) ? $point[0]->fantasy_points_acme : 0.00;
                    $fantasyTeams['fantasy_point'][] = $playerPoints;
                }

                //Handle Defense
                if ($list->fantasyPlayer->fantasyDefenseGame && $list->active) {
                    $point = $list->fantasyPlayer->fantasyDefenseGame;
                    $playerPoints = isset($point[0]) ? $point[0]->fantasy_points_acme : 0.00;
                    $fantasyTeams['fantasy_point'][] = $playerPoints;
                }

                //echo $list->fantasyPlayer->name ." | Pts: ".$playerPoints."\r\n";
            }
        }

        if (! empty($fantasyTeams)) {
            $fantasy_score = collect($fantasyTeams['fantasy_point'])->values()->sum();
        }

        return $fantasy_score;
    }
}
