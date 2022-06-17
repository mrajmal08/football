<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\FantasyTeamsRoster;
use App\Models\League;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class FillFantasyTeamsRoster extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FillFantasyTeamsRoster {--league_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fill fantasy teams roster';

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
        $league_id = $this->option('league_id');
        $systemSettings = Helper::getSystemSettingsDetails();
        if ($league_id > 0) {
            try {
                if ($league_id > 0) {
                    $leagues = League::where('id', $league_id)->get();
                } else {
                    $leagues = League::orderBy('id', 'DESC')->all();
                }

                //$leagues = League::all();
                if (! empty($leagues)) {
                    foreach ($leagues as $key=>$val) {
                        $override_system = $val->override_system;
                        if ($override_system) {
                            $week = $val->week;
                            $season = $val->season;
                            $seasonType = $val->season_type;
                        } else {
                            $week = $systemSettings['week'];
                            $season = $systemSettings['season'];
                            $seasonType = $systemSettings['season_type'];
                        }
                        $waiver_period_enabled = $systemSettings['waiver_period_enabled'];
                        $teams = FantasyTeam::where('league_id', $val->id)->get();

                        if (! empty($teams)) {
                            foreach ($teams as $tkey=>$tval) {
                                $transactions = FantasyTeamsPlayerTransaction::where('fantasy_team_id', $tval->id)
                                    ->where('week', '<=', $week)
                                    ->where('season', $season)
                                    ->where('season_type', $seasonType)
                                    ->where('player_transaction_type_id', 1)
                                    ->where(function ($q) {
                                        $q->where('active', 1)
                                            ->orWhere('bench', 1);
                                    })
                                    ->get();

                                $approved_transactions = FantasyTeamsPlayerTransaction::where('fantasy_team_id', $tval->id)
                                                    ->where('week', '<=', $week)
                                                    ->where('season', $season)
                                                    ->where('season_type', $seasonType)
                                                    ->where('player_transaction_type_id', 5)
                                                    ->where('conditional_drop', '!=', '0')
                                                    ->get()->toArray();
                                $approved_transactions = collect($approved_transactions);

                                if (! empty($transactions)) {
                                    foreach ($transactions as $skey=>$sval) {
                                        $t_week = $week;
                                        // TODO: Fix this logic.
                                        // Turned off 9/22/20
                                        $waiver_period_enabled = 0;
                                        if ($waiver_period_enabled == 1) {
                                            $filtered = $approved_transactions->where('conditional_drop', $sval->fantasy_player_id);
                                            if (isset($filtered)) {
                                                $filteredll = $filtered->all();
                                                $plucked_teams = $filtered->pluck('conditional_drop');

                                                // Not sure what this is trying to do. But it causes an issue in generating TeamRoster if a conditional drop is made for a player

                                                // $plucked_teams=$plucked_teams->all();
                                                $plucked_teams = [];
                                            }
                                            if (empty($plucked_teams)) {
                                                $transactions_data = [];
                                                $transactions_data = [
                                                    'fantasy_player_id' 			=> $sval->fantasy_player_id,
                                                    'fantasy_team_id' 				=> $sval->fantasy_team_id,
                                                    'player_transaction_type_id' 	=> $sval->player_transaction_type_id,
                                                    'league_id' 					=> $sval->league_id,
                                                    'active' 						=> $sval->active,
                                                    'week' 							=> $t_week,
                                                    'season' 						=> $sval->season,
                                                    'season_type' 					=> $sval->season_type,
                                                    'bench' 						=> $sval->bench,
                                                ];

                                                \App\Models\FantasyTeamsRoster::updateOrCreate(
                                                    [
                                                        'fantasy_team_id' => $sval->fantasy_team_id,
                                                        'league_id' => $sval->league_id,
                                                        'week'=>$t_week,
                                                        'season'=>$sval->season,
                                                        'season_type'=>$sval->season_type,
                                                        'fantasy_player_id'=>$sval->fantasy_player_id,
                                                        'player_transaction_type_id' 	=> $sval->player_transaction_type_id,
                                                    ],
                                                    $transactions_data
                                                );
                                            }
                                        } else {
                                            $transactions_data = [];
                                            $transactions_data = [
                                                'fantasy_player_id' 			=> $sval->fantasy_player_id,
                                                'fantasy_team_id' 				=> $sval->fantasy_team_id,
                                                'player_transaction_type_id' 	=> $sval->player_transaction_type_id,
                                                'league_id' 					=> $sval->league_id,
                                                'active' 						=> $sval->active,
                                                'week' 							=> $t_week,
                                                'season' 						=> $sval->season,
                                                'season_type' 					=> $sval->season_type,
                                                'bench' 						=> $sval->bench,
                                            ];

                                            \App\Models\FantasyTeamsRoster::updateOrCreate(
                                                [
                                                    'fantasy_team_id' => $sval->fantasy_team_id,
                                                    'league_id' => $sval->league_id,
                                                    'week'=>$t_week,
                                                    'season'=>$sval->season,
                                                    'season_type'=>$sval->season_type,
                                                    'fantasy_player_id'=>$sval->fantasy_player_id,
                                                    'player_transaction_type_id' 	=> $sval->player_transaction_type_id,
                                                ],
                                                $transactions_data
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $this->info('Fantasy team roster details inserted successfully');
                } else {
                    echo 'No reosters found to set.';
                }
            } catch (Exception $e) {
                echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
            }
        } else {
            $this->error('League id is required');
        }
    }
}
