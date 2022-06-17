<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Dev;
use App\Http\Controllers\DraftController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [WelcomeController::class, 'show']);

Route::get('/home', [HomeController::class, 'show']);

Route::get('/dev', [Dev\DevController::class, 'show']);

Route::get('/phpinfo', [Dev\DevController::class, 'phpinfo']);

Route::get('/dev/league-scoreboard/', [Dev\DevController::class, 'showLeagueScoreboard']);

Route::get('/dev/division/', [Dev\DevController::class, 'showDivision']);

Route::get(
    '/dev/conference/',
    [Dev\DevController::class, 'showConference']
);

Route::get('/dev/live-game-scoreboard/', [Dev\DevController::class, 'showLiveGameScoreBoard']);

Route::get('/dev/fd-api/', [Dev\DevController::class, 'showFantasyDataResponse']);

     Route::get(
         '/dev/fd-object/',
         [Dev\DevController::class, 'showFantasyDataObjectContainerInstantiated']
     );

Route::impersonate();

Route::namespace('Dev')->middleware('auth')->group(function () {


    Route::get('/dev/draft-room/', [Dev\DevController::class, 'showDraftRoom']);
    Route::get('/dev/countdown-timer', [Dev\DevController::class, 'showCountdownTimer']);
});

Route::middleware('auth', 'subscribed')->group(function () {
    // Password Reset...
    Route::get('/password/reset/{token?}', [Auth\PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/email', [Auth\PasswordController::class, 'sendResetLinkEmail']);
    Route::post('/password/reset', [Auth\PasswordController::class, 'reset']);

    Route::get('/league', [LeagueController::class, 'showLeague']);

    /** settings/league page **/
    Route::get('/league-details', [LeagueController::class, 'showLeagueDetails'])->name('league.details');

    /** settings/league waivers **/
    Route::get('/league-waivers', [LeagueController::class, 'showWaivers'])->name('league.waivers');

    Route::put('/league/update', [LeagueController::class, 'update'])->name('league.update');
    Route::post('/league/clearteam', [LeagueController::class, 'clearteam'])->name('league.clearteam');
    Route::post('/league/startleaque', [LeagueController::class, 'startleaque'])->name('league.startleaque');
    Route::get('/league/home', [LeagueController::class, 'showLeagueHome']);
    Route::get('/league/schedule', [LeagueController::class, 'showLeagueSchedule']);
    Route::get('/league/transactions', [LeagueController::class, 'showLeagueTransactions']);
    Route::get('/league/first-division', [LeagueController::class, 'showFirstDivision'])->name('team.first.division');
    Route::get('/league/divisions', [LeagueController::class, 'showDivisions'])->name('team.division');
    Route::get('/league/active-fantasy-teams', [LeagueController::class, 'activeFantasyTeams'])->name('team.activeteams');
    Route::post('league/invitations', [LeagueController::class, 'storeInvitations'])->name('league.storeInvitation');
    Route::get('/league/invitation-list', [LeagueController::class, 'getInvitationList'])->name('league.getInvitation');
    Route::get('/league/team', [LeagueController::class, 'getLeagueTeam']);

    Route::get('/league/alldivisions', [LeagueController::class, 'alldivisions'])->name('team.alldivision');
    Route::post('/league/leaque_team_rank', [LeagueController::class, 'leaqueTeamRank'])->name('team.division.rank');
    Route::get('/league/task', [LeagueController::class, 'showTask'])->name('team.task');

    // Route::get('/draft', [DraftController::class, 'showDraft']);
    Route::get('/draft/draft-room', [DraftController::class, 'showDraftRoom']);
    Route::get('/draft/draft-prep', [DraftController::class, 'showDraftPrep']);
    Route::get('/draft/draft-results', [DraftController::class, 'showDraftResults']);
    Route::post('/draft/draft-order', [DraftController::class, 'assignDraftOrder']);
    Route::post('/draft/pick', [PlayerController::class, 'addPlayerOnTimeout']);
    Route::get('/draft/league-draft-data', [DraftController::class, 'leagueDraftData']);

    Route::get('/team', [TeamController::class, 'showTeam']);
    //Route::get('/team-list', [TeamController::class, 'showTeamList'])->name('team.list');
    Route::get('/team/table-list', [TeamController::class, 'showTeamTableList'])->name('team.table.list');
    Route::get('/team/my-team', [TeamController::class, 'showMyTeam'])->name('team.myteam');
    Route::get('/team/roster', [TeamController::class, 'getTeamRoster_new']);
    //	Route::get('/team/roster/week/{week}/season/{season}/teams/{teams}', [TeamController::class, 'showTeamRoster_new'])->name('team.roster');
    Route::get('/team/league-teams', [TeamController::class, 'showTeamLeagueTeams']);
    Route::get('/team/settings', [TeamController::class, 'showSettings']);
    Route::put('/team/settings', [TeamController::class, 'updateSettings'])->name('team.update');
    Route::get('/team/details', [TeamController::class, 'showTeamDetails'])->name('team.details');
    Route::post('/team/settings/logo', [TeamController::class, 'storeLogo']);
    Route::get('/team/roster-details', [TeamController::class, 'getRosterDetails']);

    Route::get('/team/roster-grid-data', [TeamController::class, 'getTeamRosterGridData']);

    Route::get('/team_new/roster', [TeamController::class, 'getTeamRoster_new']);
    Route::get('/team/roster/week/{week}/season/{season}/teams/{teams}', [TeamController::class, 'showTeamRoster_new'])->name('team.roster_new');

    Route::get('/player_eloquent', [PlayerController::class, 'getPlayerEloquent'])->name('player2');
    Route::get('/player', [PlayerController::class, 'getPlayer'])->name('player');
    Route::get('/players', [PlayerController::class, 'showPlayersEloquent'])->name('players.list');
    Route::get('/players2', [PlayerController::class, 'showPlayers'])->name('players.list2');
    Route::get('/players/stats', [PlayerController::class, 'showPlayerStats']);
    Route::get('/players/injury-report', [PlayerController::class, 'showPlayerInjuryReport']);
    Route::get('/players/depth-charts', [PlayerController::class, 'showPlayerDepthCharts']);
    Route::post('/players/player-transaction', [PlayerController::class, 'insertTransactionDetails']);
    // Route::post('/players/player-draft_transaction', [PlayerController::class, 'insertDraftTransactionDetails']);
    // Route::post('/players/league-player-transaction', [PlayerController::class, 'LeagueinsertTransactionDetails']);

    Route::get('/score_review', [PlayerController::class, 'score_review']);
    Route::post('/save_score_review', [PlayerController::class, 'save_score_review']);

    Route::get('/score_review', [PlayerController::class, 'score_review']);
    Route::put('/players/unwatch', [PlayerController::class, 'unwatchPlayer']);
    Route::get('/players/check-max-position-reached', [PlayerController::class, 'checkPlayerMaximumPositionReached']);
    Route::put('/players/remove', [PlayerController::class, 'removePlayer']);
    Route::post('/players/remove-claim-player', [PlayerController::class, 'removeClaimPlayer']);
    Route::get('/players/team', [PlayerController::class, 'getPlayerTeams']);
    Route::get('/players/positions', [PlayerController::class, 'getPlayerPositions']);
    Route::post('/players/bench-player', [PlayerController::class, 'addBenchPlayer']);
    Route::post('/players/tqb-player', [PlayerController::class, 'addTqbPlayer']);
    Route::post('/players/conditional_remove', [PlayerController::class, 'conditionalRemovePlayer']);
    Route::get('/claim_players', [PlayerController::class, 'getClaimPlayers'])->name('claimplayers');

    Route::get('/players-injury-report', [PlayerController::class, 'getPlayerInjuryReport']);

    Route::get('/scores', [ScoreController::class, 'showScores']);
    Route::get('/scores/league-games', [ScoreController::class, 'showScoreLeaueGames']);
    Route::get('/scores/league-playoffs', [ScoreController::class, 'getScoreLeauePlayoffs']);
    Route::get('/scores/league-playoffs/{week}', [ScoreController::class, 'showScoreLeauePlayoffs'])->name('league.playoffs');
    Route::get('/scores/nfl-games', [ScoreController::class, 'showScoreNflGames']);
    Route::get('/scores/fantasy-games', [ScoreController::class, 'getFantasyGames'])->name('get-fantasy-details');
    Route::get('/scores/fantasy-games/week/{week}/season_type/{season_type}/season/{season}', [ScoreController::class, 'showFantasyGames'])->name('scores.fantasy-games');
    Route::get('/scores/fantasy-games/week/{week}/season_type/{season_type}/season/{season}/game/{game}', [ScoreController::class, 'showFantasyGames'])->name('scores.fantasy-game');
    Route::get('/live-players', [ScoreController::class, 'getLivePlayerDetails']);
    //Route::get('/statistics', [ScoreController::class, 'getStatistics']);
    Route::get('/scores/nfl-games/box-scores/{game_key}/{week}/{season}', [ScoreController::class, 'showBoxScoreNflGames']);
    Route::get('/nfl-key-players/', [ScoreController::class, 'getKeyPlayerGame']);
    Route::get('/scores/get-score-play/', [ScoreController::class, 'getScoringDetails'])->name('scores.score-play');

    Route::get('/average_score', [ScoreController::class, 'getAverageDetails'])->name('scores.average_score');

    Route::get('/scores/get-live-scoreboard', [ScoreController::class, 'getLiveTeamScoreboard']);
    //Route::get('/scores/get-live-players', [ScoreController::class, 'getLiveTeamPlayers']);
    Route::get('/scores/get-team-player-stat', [ScoreController::class, 'getTeamPlayerStat']);

    Route::get('/standings', [StandingController::class, 'showStandings']);
    Route::get('/standings/head-to-head', [StandingController::class, 'showStandingsHeadToHead']);

    Route::get('/standings/tournament', [StandingController::class, 'showStandingsTournament']);
    Route::get('/standings/coach-ratings', [StandingController::class, 'showStandingsCoachRating']);
    Route::get('/standings/coach-ratings/{id}/{id2}', [StandingController::class, 'showStandingsCoachRating']);

    Route::get('/standings/overall', [StandingController::class, 'showStandingsOverall']);
    Route::get('/standings/overall/{id}/{id2}', [StandingController::class, 'showStandingsOverall']);
    Route::post('/get-matchup-result', [StandingController::class, 'getMatchupResult']);

    Route::get('/system-settings', [SystemController::class, 'systemSetting'])->name('system.settings');
    Route::put('/system/update', [SystemController::class, 'systemUpdate'])->name('system.update');
    Route::get('/get_system_setting', [SystemController::class, 'get_system_setting'])->name('system');
    Route::get('/players-depthchart', [PlayerController::class, 'getPlayersDepthChart']);
    Route::get('/fantasy_players', [PlayerController::class, 'getAllFantasyPlayers']);
    //Route::get('/get_three_seasons', [PlayerController::class, 'getAllFantasyPlayers']);
    // Route::put('/system/update_schedules', function () {
    // 	//call the UpdateSchedules console command
    // 		  \Artisan::call('UpdateSchedules');

    // 	//return 'Updated Schedules has been updated!';
    // });

    // Route::get('/get_three_seasons', function () {

    // 		$response= \Helper::getThreeSystemSeasons();
    // 		  return response()->json($response);

    // 	//return 'Updated Schedules has been updated!';
    // });
    // Route::put('/system/update_boxscores_finished_games', function () {

    // 	//call the UpdateBoxScoresFinishedGames console command
    // 		  \Artisan::call('UpdateBoxScoresFinishedGames');

    // 	//return 'Updated BoxScores Finished Games';
    // });

    // Route::put('/system/update_box_scores', function () {

    // 	//call the UpdateBoxScores console command
    // 		  \Artisan::call('UpdateBoxScores');

    // 	//return 'Updated BoxScores';
    // });

    // Route::put('/system/update_league_postseason_scores', function () {

    // 	//call the UpdateBoxScoresFinishedGames console command
    // 		  \Artisan::call('UpdateLeaguePostseasonScores');

    // 	//return 'Updated League Postseason Scores';
    // });

    Route::get('/get-all-league-game', [ScoreController::class, 'getAllLeagueGame']);
    Route::get('/get-league-game', [ScoreController::class, 'getLeagueGame']);

    Route::get('/allteam_rank', [LeagueController::class, 'allteam_rank']);
    Route::get('/tournament-graph', [LeagueController::class, 'tournamentGraph']);
    Route::get('/season-post-details', [ScoreController::class, 'getSeasonPostScoreDetails']);
    Route::get('/get-postseason-teams', [ScoreController::class, 'getPostSeasonTeams']);
    Route::get('/nfl-schedules', [ScoreController::class, 'getNFLSchedules']);

    Route::get('/nfl-game-score', [ScoreController::class, 'getNFLGameScores']);
    Route::get('/fantasy_points_acme', [PlayerController::class, 'getFantasy_points_acme']);
    Route::get('/league-draft-results', [DraftController::class, 'showLeagueDraftResults']);

    Route::get('/fantasy_player_news', [PlayerController::class, 'getFantasyPlayerNews']);

    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
    Route::post('/stripePost', [StripePaymentController::class, 'stripePost'])->name('stripePost');

    //New Routes added in 2020
    Route::get('/getUserFantasyTeamRoster/{fantasyTeamId?}', [PlayerController::class, 'getUserFantasyTeamRoster']);

    Route::get('/phpinfo', function () {
        echo phpinfo();
    });

    Route::get('/testwire', function () {
        //\Artisan::call('UpdateLeagueGames');

        \Artisan::call('ProcessWaiverWire', ['--league_id' => 2]);

//         \Artisan::call('UpdateLeagueTeamRankings', ['--league_id' => 2]);

    // 	//\Artisan::call('SyncStGameData', ['--year' => '2018','--week' => 1]);
    // 	//\Artisan::call('CalculateFantasyPlayerGameFantasyPoints',['--year' => '2018','--week' => '2','--isProjection' => false]);
    // 	//call the UpdateBoxScores console command
    // 		 // \Artisan::call('ProcessWaiverWire');
    // 			//\Artisan::call('FillFantasyTeamsRoster');
    });
});
