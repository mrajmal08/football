<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateTeams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update teams';

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
        $apiInstance = new \Acme\FantasyDataScores\Api\DefaultApi(
                       new FdClient()
        );

        try {
            $result = $apiInstance->teamsActive('json');
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $response = Http::withHeaders([
                        'Ocp-Apim-Subscription-Key' => '4d9514a8a36442ed9c07468bbf4aecf7',
                    ])->get('https://api.sportsdata.io/v3/nfl/scores/json/Players/'.$val['key']);
                    $team_data = [
                        'key'								=>$val['key'],
                        'team_id'     						=>$val['team_id'],
                        'player_id'     			    	=>$val['player_id'],
                        'city'     			    			=>$val['city'],
                        'name'     							=>$val['name'],
                        'conference'     					=>$val['conference'],
                        'division'     						=>$val['division'],
                        'full_name'     					=>$val['full_name'],
                        'stadium_id'     					=>$val['stadium_id'],
                        'bye_week'     						=>$val['bye_week'],
                        'average_draft_position'     		=>$val['average_draft_position'],
                        'average_draft_position_p_p_r'     	=>$val['average_draft_position_ppr'],
                        'head_coach'     	   				=>$val['head_coach'],
                        'offensive_coordinator'    			=>$val['offensive_coordinator'],
                        'defensive_coordinator'     		=>$val['defensive_coordinator'],
                        'special_teams_coach'     			=>$val['special_teams_coach'],
                        'offensive_scheme'     		   		=>$val['offensive_scheme'],
                        'defensive_scheme'     		   		=>$val['defensive_scheme'],
                        'upcoming_salary'     		   		=>$val['upcoming_salary'],
                        'upcoming_opponent'     		   	=>$response[0]['UpcomingGameOpponent'],
                        'upcoming_opponent_rank'     		=>$val['upcoming_opponent_rank'],
                        'upcoming_opponent_position_rank'   =>$val['upcoming_opponent_position_rank'],
                        'upcoming_fan_duel_salary'     		=>$val['upcoming_fan_duel_salary'],
                        'upcoming_draft_kings_salary'     	=>$val['upcoming_draft_kings_salary'],
                        'upcoming_yahoo_salary'     		=>$val['upcoming_yahoo_salary'],
                        'primary_color'     		   		=>$val['primary_color'],
                        'secondary_color'     		   		=>$val['secondary_color'],
                        'tertiary_color'     		   		=>$val['tertiary_color'],
                        'quaternary_color'     		   		=>$val['quaternary_color'],
                        'wikipedia_logo_url'     		   	=>$val['wikipedia_logo_url'],
                        'wikipedia_word_mark_url'     		=>$val['wikipedia_word_mark_url'],
                        'global_team_id'     		   		=>$val['global_team_id'],
                        'draft_kings_name'     		   		=>$val['draft_kings_name'],
                        'draft_kings_player_id'     		=>$val['draft_kings_player_id'],
                        'fan_duel_name'     		   		=>$val['fan_duel_name'],
                        'fan_duel_player_id'     		   	=>$val['fan_duel_player_id'],
                        'fantasy_draft_name'     		   	=>$val['fantasy_draft_name'],
                        'fantasy_draft_player_id'     		=>$val['fantasy_draft_player_id'],
                        'yahoo_name'     		   			=>$val['yahoo_name'],
                        'yahoo_player_id'     		   		=>$val['yahoo_player_id'],
                    ];
                    $model = \App\Models\FantasyData\Team::updateOrCreate(
                        ['team_id'   => $val['team_id']],
                        $team_data
                    );
                }
                echo "Team details has been added/updated successfully\r\n";
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
