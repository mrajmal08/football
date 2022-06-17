<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use Illuminate\Console\Command;

class UpdatePlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdatePlayers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update players informations';

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
        $apiInstance = new \Acme\FantasyDataStats\Api\DefaultApi(
            new FdClient()
        );
        try {
            $this->info('Updating Players');
            $result = $apiInstance->playerDetailsByAvailable('json');
            //dd($result);
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    //$this->info('Updating '. $val['first_name'] . ' '. $val['last_name']);
                    $player_data = [
                        'player_id'					       =>$val['player_id'],
                        'team'     					       =>$val['team'],
                        'first_name'     			       =>$val['first_name'],
                        'last_name'     			       =>$val['last_name'],
                        'position'     				       =>$val['position'],
                        'status'     				       =>$val['status'],
                        'height'     				       =>$val['height'],
                        'weight'     				       =>$val['weight'],
                        'birth_date'     			       =>$val['birth_date'],
                        'college'     				       =>$val['college'],
                        'fantasy_position'     		       =>$val['fantasy_position'],
                        'active'     				       =>$val['active'],
                        'position_category'     	   	   =>$val['position_category'],
                        'name'     	  					   =>$val['name'],
                        'age'     	 					   =>$val['age'],
                        'experience_string'     	       =>$val['experience_string'],
                        'experience'     	       		   =>$val['experience'],
                        'birth_date_string'     		   =>$val['birth_date_string'],
                        'photo_url'     				   =>$val['photo_url'],
                        'bye_week'     				       =>$val['bye_week'],
                        'upcoming_game_opponent'     	   =>$val['upcoming_game_opponent'],
                        'upcoming_game_week'     		   =>$val['upcoming_game_week'],
                        'short_name'     				   =>$val['short_name'],
                        'average_draft_position'     	   =>$val['average_draft_position'],
                        'depth_position_category'     	   =>$val['depth_position_category'],
                        'depth_position'     			   =>$val['depth_position'],
                        'depth_display_order'     		   =>$val['depth_display_order'],
                        'current_team'     				   =>$val['current_team'],
                        'college_draft_team'     		   =>$val['college_draft_team'],
                        'college_draft_year'     		   =>$val['college_draft_year'],
                        'college_draft_round'     		   =>$val['college_draft_round'],
                        'college_draft_pick'     		   =>$val['college_draft_pick'],
                        'is_undrafted_free_agent'     	   =>$val['is_undrafted_free_agent'],
                        'height_feet'     				   =>$val['height_feet'],
                        'height_inches'     			   =>$val['height_inches'],
                        'upcoming_opponent_rank'     	   =>$val['upcoming_opponent_rank'],
                        'upcoming_opponent_position_rank'  =>$val['upcoming_opponent_position_rank'],
                        'current_status'     			   =>$val['current_status'],
                        'upcoming_salary'     			   =>$val['upcoming_salary'],
                        'fantasy_alarm_player_id'     	   =>$val['fantasy_alarm_player_id'],
                        'sport_radar_player_id'     	   =>$val['sport_radar_player_id'],
                        'rotoworld_player_id'     		   =>$val['rotoworld_player_id'],
                        'roto_wire_player_id'     		   =>$val['roto_wire_player_id'],
                        'stats_player_id'     			   =>$val['stats_player_id'],
                        'sports_direct_player_id'     	   =>$val['sports_direct_player_id'],
                        'xml_team_player_id'     		   =>$val['xml_team_player_id'],
                        'fan_duel_player_id'     		   =>$val['fan_duel_player_id'],
                        'draft_kings_player_id'     	   =>$val['draft_kings_player_id'],
                        'yahoo_player_id'     			   =>$val['yahoo_player_id'],
                        'injury_status'     			   =>$val['injury_status'],
                        'injury_body_part'     			   =>$val['injury_body_part'],
                        'injury_start_date'     		   =>$val['injury_start_date'],
                        'injury_notes'     				   =>$val['injury_notes'],
                        'fan_duel_name'     			   =>$val['fan_duel_name'],
                        'draft_kings_name'     			   =>$val['draft_kings_name'],
                        'yahoo_name'     				   =>$val['yahoo_name'],
                        'fantasy_position_depth_order'     =>$val['fantasy_position_depth_order'],
                        'injury_practice'     			   =>$val['injury_practice'],
                        'injury_practice_description'      =>$val['injury_practice_description'],
                        'declared_inactive'     		   =>$val['declared_inactive'],
                        'upcoming_fan_duel_salary'     	   =>$val['upcoming_fan_duel_salary'],
                        'upcoming_draft_kings_salary'      =>$val['upcoming_draft_kings_salary'],
                        'upcoming_yahoo_salary'     	   =>$val['upcoming_yahoo_salary'],
                        'team_id'     				       =>$val['team_id'],
                        'global_team_id'     		       =>$val['global_team_id'],
                        'fantasy_draft_player_id'          =>$val['fantasy_draft_player_id'],
                        'fantasy_draft_name'     		   =>$val['fantasy_draft_name'],
                    ];
                    \App\Models\FantasyData\Player::updateOrCreate([
                        //Add unique field combo to match here
                        'player_id'   => $val['player_id'],
                    ], $player_data);
                }
                //$this->info("Player details has been added/updated successfully\r\n");
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
