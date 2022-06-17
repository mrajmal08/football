<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeaguePostseasonScores;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class UpdateLeaguePostseasonScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //TODO: --finished is not used. Is it needed?
    protected $signature = 'UpdateLeaguePostseasonScores {--league_id=}  {--week=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update the League Postseason Scores';

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
        $week = $this->option('week') ?? $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];
        $league_id = $this->option('league_id');

        //dd($week);

        if ($systemSettings['season_type'] != 3) {
            return $this->error('Can only be ran in post season mode.');
        }

        if ($league_id > 0) {
            $leagues = League::where('id', $league_id)->get();
        } else {
            $leagues = League::all();
        }

        if (! empty($leagues)) {
            try {
                foreach ($leagues as $lkey=>$lval) {
                    $fantasy_teams = FantasyTeam::where('league_id', $lval['id'])->get();

                    if (! empty($fantasy_teams)) {
                        foreach ($fantasy_teams as $key=>$val) {
                            $team_score_result = Helper::getFantasyTeamDataByWeekEloquent($season, $seasonType, $week, $val->id);
                            $team_score = $this->getFantasyScore($team_score_result);
                            $team_tds = $this->getFantasyTds($team_score_result);
                            //dd($team_tds);

                            $teamData = [
                                'league_id'         => $lval['id'],
                                'fatasy_team_id'    => $val->id,
                                'season'            => $season,
                                'season_type'       => $seasonType,
                                'week'              => $week,
                                'points_for'        => $team_score,
                                'tds'               => $team_tds,
                            ];

                            //dd($teamData);

                            $model = LeaguePostseasonScores::updateOrCreate(
                                [
                                    'league_id'   => $lval['id'],
                                    'season'   => $season,
                                    'season_type'=> $seasonType,
                                    'week'=> $week,
                                    'fatasy_team_id'=>$val->id,
                                ],
                                $teamData
                            );
                        }
                    }
                    $this->info('League game details has been updated successfully for week '.$week);
                }
            } catch (Exception $e) {
                $this->error('Exception when calling api: ', $e->getMessage(), PHP_EOL);
            }
        } else {
            $this->info('No league game details available for week '.$week);
        }
    }

    public function getFantasyTds($fantasy_roster_data)
    {
        //dd('here');
        $fantasyTeams = [];

        $sum = 0;
        if (! empty($fantasy_roster_data->FantasyTeamRoster)) {
            foreach ($fantasy_roster_data->FantasyTeamRoster as $list) {
                $point = null;
                if ($list->fantasyPlayer->playerGame) {
                    // $point=$list->fantasyPlayer->playerGame;
                    // dd($list->fantasyPlayer->playerGame[0]->receiving_touchdowns);
                    if (! empty($list->fantasyPlayer->playerGame[0])) {
                        // dd($list->fantasyPlayer->playerGame[0]);
                        $sum += $list->fantasyPlayer->playerGame[0]->receiving_touchdowns;
                        $sum += $list->fantasyPlayer->playerGame[0]->rushing_touchdowns;
                        $sum += $list->fantasyPlayer->playerGame[0]->passing_touchdowns;
                    }
                }
                if ($list->fantasyPlayer->fantasyDefenseGame && $list->fantasyPlayer->position == 'DEF') {
                    //$point=$list->fantasyPlayer->fantasyDefenseGame;
                    if (! empty($list->fantasyPlayer->fantasyDefenseGame[0])) {
                        $sum += $list->fantasyPlayer->fantasyDefenseGame[0]->interception_return_touchdowns;
                        $sum += $list->fantasyPlayer->fantasyDefenseGame[0]->fumble_return_touchdowns;
                    }
                }
            }
        }
        //dd($sum);
        return $sum;
    }

    private function getFantasyScore($fantasy_roster_data)
    {
        $fantasy_score = 0;
        $fantasyTeams = [];

        if (! empty($fantasy_roster_data->FantasyTeamRoster)) {
            foreach ($fantasy_roster_data->FantasyTeamRoster as $list) {
                $point = null;
                if ($list->fantasyPlayer->playerGame) {
                    $point = $list->fantasyPlayer->playerGame;
                }
                if ($list->fantasyPlayer->fantasyDefenseGame && $list->fantasyPlayer->position == 'DEF') {
                    $point = $list->fantasyPlayer->fantasyDefenseGame;
                }
                if (! empty($point[0])) {
                    $fantasyTeams['fantasy_point'][] = $point[0]->fantasy_points_acme;
                }
            }
        }

        if (! empty($fantasyTeams)) {
            $fantasy_score = collect($fantasyTeams['fantasy_point'])->values()->sum();
        }

        return number_format((float) $fantasy_score, 2, '.', '');
    }
}
