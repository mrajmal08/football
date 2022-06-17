
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

require('./home');
require('./dev');
require('./draftroom');
require('./team-card-table');
require('./team-draft-card');
require('./players-table');
require('./team-card');
require('./league-scoreboard');
require('./division');
require('./conference');
require('./live-game-scoreboard');
require('./live-players-score');
require('./live-team-score');
require('./live-team-bench');
require('./live-team-score-post-season');
require('./live-player-score-post-season');
require('./appads-component');

require('./league');
require('./league-home');
require('./league-schedule');
require('./league-transactions');
require('./league-draft-picks');
require('./leaguetask-component');
require('./leaguesnapshot-component');
require('./active-fantasy-team-component');

require('./leaque-schedule-score-component');

require('./nflnews-component');
require('./snapshot');
require('./league-team-rank');
require('./draft');
require('./draft-room');
require('./draft-prep');
require('./draft-results');

require('./nflindividual-game-score-component');

require('./team');
require('./team-roster');
require('./team-league-teams');
require('./team-settings');
require('./team-roster-player-offense');
require('./team-roster-player-kicker');
require('./team-roster-player-defense');
require('./team-roster-player-special');
require('./news-item-component');

require('./players');
require('./players-stats');
require('./players-injury-report');
require('./players-depth-charts');
require('./liveplayer-stats-component');

require('./scores');
require('./scores-league-games');
require('./scores-league-playoffs');
require('./scores-nfl-games');
require('./box-scores');
require('./jumbo-game-score');
require('./key-players');
require('./team-player-stats');
require('./social-feed');
require('./game-details');
require('./scores-ticker');
require('./box-score-brief');
require('./scores-ticker-game');

require('./standings');
require('./standings-head-to-head');
require('./standings-overall');
require('./standings-tournament');
require('./standings-coach-ratings');

require('./countdown-timer');
require('./countdown');

require('./player-detail-modal');

require('./fantasy-team-weekly-matchup-result');
require('./nfl-schedule');
require('./team-players-table');

require('./player-individual-game-progress');
require('./player-actions-component');

require('./fantasy-team-quickmanage');
require('./league-waivers');

require('./queue-component');
require('./scoringreview');

require('./fantasyteam-roster');

require('./fantasyteam-roster-player');
require('./fantasyteam-roster-stats-player');

require('./vuetifyaudio');
require('./fantasyteam-roster-stats-defence-player');
require('./fantasyteam-roster-stats-kickerplayer');

/** 2020 Upates **/
Vue.component('player-draft-card', require('./PlayerDraftCardComponent.vue'));
