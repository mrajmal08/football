<?php

namespace App\Console\Commands;

use App\Http\Controllers\PlayerController;
use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\Player;
use App\Models\FantasyData\Team;
use App\Models\FantasyTeam;
use App\Models\FantasyTeamsPlayerTransaction;
use App\Models\League;
use App\Models\LeagueTeamRanking;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class ProcessWaiverWire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProcessWaiverWire {--league_id=} {--one}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for ProcessWaiverWire';

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
        $week = $systemSettings['week'];
        $weekRank = ($week > 1) ? $week - 1 : $week;
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];

        $league_id = $this->option('league_id');
        $oneByOne = $this->option('one');

        if ($league_id > 0) {
            $leagues = League::where('id', $league_id)->get()->toArray();
        } else {
            $leagues = League::get()->toArray();
        }

        //dd('stop here');

//        $leagues 			= League::get()->toArray();

        if (! empty($leagues)) {
            try {
                foreach ($leagues as $lkey=>$lval) {
                    $leaque_team_ranking = LeagueTeamRanking::where('league_id', $lval['id'])
                            ->where('season', $season)
                            ->where('season_type', $seasonType)
                            ->where('week', $weekRank)
                            //->with(['fantasyTeam'])
                            ->orderBy('overall_coach_rank', 'desc')
                            ->get()->toArray();

                    foreach ($leaque_team_ranking as $key=> $team_value) {
                        $teamClaimRequests = FantasyTeamsPlayerTransaction::where('league_id', $lval['id'])
                                            ->where('week', '=', $week)
                                            ->where('season', $season)
                                            // ->where('fantasy_player_id', $list['fantasy_player_id'])
                                            ->where('fantasy_team_id', $team_value['fatasy_team_id'])
                                            ->where('season_type', $seasonType)
                                            ->where('player_transaction_type_id', 5)
                                            ->where('active', 1)
                                            ->orderBy('created_at', 'asc')
                                            ->get();
                        // if (count($teamClaimRequests) > 0) {
                        //     dd($teamClaimRequests);
                        // }

                        if (! empty($teamClaimRequests) && $team_value) {
                            foreach ($teamClaimRequests as $waiverRequest) {
                                // Approve the transaction. In doing so, it will also add the player.
                                // Perform a lookup transaction with the existing claim id
                                $request = new Request(
                                    [
                                        'player_id' => null,
                                        'fantasy_team_id' => null,
                                        'transaction_id' => 7,
                                        'transaction_locator' => $waiverRequest->id,
                                    ],
                                    ['CONTENT_TYPE' => 'application/json']
                                );
                                $playerController = new PlayerController();
                                $response = $playerController->insertTransactionDetails($request);

                                $responseData = $response->original;
                                if ($responseData['success']) {

                                    // Reject requests for the same fantasy player
                                    // Look to see if any other fantasy_teams were trying to claim this same player and cancel them.
                                    $claim_reject_transactions = FantasyTeamsPlayerTransaction::where('league_id', $lval['id'])
                                    ->where('week', '=', $week)
                                    ->where('season', $season)
                                    ->where('fantasy_player_id', $waiverRequest->fantasy_player_id)
                                    ->where('fantasy_team_id', '!=', $team_value['fatasy_team_id'])
                                    ->where('season_type', $seasonType)
                                    ->where('player_transaction_type_id', 5)
                                    ->where('active', 1)
                                    ->orderBy('created_at', 'asc')
                                    ->get();

                                    if (! empty($claim_reject_transactions)) {
                                        foreach ($claim_reject_transactions as $list) {
                                            if (! empty($list)) {
                                                $request = new Request(
                                                    [
                                                        // 'player_id' => null,
                                                        // 'fantasy_team_id' => null,
                                                        'transaction_id' => 6,
                                                        'transaction_locator' => $list->id,
                                                    ],
                                                    ['CONTENT_TYPE' => 'application/json']
                                                );
                                                $playerController = new PlayerController();
                                                $response = $playerController->insertTransactionDetails($request);
                                            }
                                        }
                                    }
                                } else {
                                    // Output info and return
                                    //dd($responseData);

                                    // If it was denied for some reason, just reject the claim
                                    $request = new Request(
                                        [
                                            'transaction_id' => 6,
                                            'transaction_locator' => $waiverRequest->id,
                                        ],
                                        ['CONTENT_TYPE' => 'application/json']
                                    );
                                    $playerController = new PlayerController();
                                    $response = $playerController->insertTransactionDetails($request);
                                }

                                // Exit App if one by one
                                if ($oneByOne) {
                                    $this->info('Processed one waiver request.');

                                    return;
                                }
                            }
                        }
                    }
                }

                // Turn off waivers once we are done with all processing.
                $systemSettingsModel = SystemSetting::find(1);
                $systemSettingsModel->waiver_period_enabled = 0;
                $systemSettingsModel->save();
            } catch (Exception $e) {
                echo 'Exception when performing action: ', $e->getMessage(), PHP_EOL;
            }
        }
    }

    public function moveItemToEnd($collection, $key)
    {
        return $collection->reject(function ($value) use ($key) {
            return $value['position'] == $key;
        })
        ->merge(
            $collection->filter(function ($value) use ($key) {
                return $value['position'] == $key;
            })
        );
    }

    public function moveItemToBegin($collection, $key)
    {
        $newcol2 = $collection->firstWhere('position', 0);
        $newcol = $collection->firstWhere('position', $key);

        return $collection->
                    reject(function ($value) use ($key) {
                        return $value['position'] == $key;
                    })->prepend($newcol, 0)
               ->push($newcol2)
               ->values()->all();
    }
}
