<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use Illuminate\Console\Command;

class UpdateFantasyPlayers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateFantasyPlayers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update fantasy players informations';

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
            $result = $apiInstance->fantasyPlayersWithAdp('json');
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $preName = '';
                    if ($val['position'] == 'DEF') {
                        $preName = 'DEF ';
                    }
                    $fantasy_player_data = [
                        'fantasy_player_key'			=>$val['fantasy_player_key'],
                        'player_id'     				=>$val['player_id'],
                        'name'     			       		=>$preName.$val['name'],
                        'team'     			       		=>$val['team'],
                        'position'     				    =>$val['position'],
                        'average_draft_position'     	=>$val['average_draft_position'],
                        'average_draft_position_p_p_r'  =>$val['average_draft_position_ppr'],
                        'bye_week'     				    =>$val['bye_week'],
                        'last_season_fantasy_points'    =>$val['last_season_fantasy_points'],
                        'projected_fantasy_points'     	=>$val['projected_fantasy_points'],
                        'auction_value'     		    =>$val['auction_value'],
                        'auction_value_p_p_r'     		=>$val['auction_value_ppr'],
                        'average_draft_position_id_p'   =>$val['average_draft_position_idp'],
                    ];
                    $model = \App\Models\FantasyData\FantasyPlayer::updateOrCreate([
                        //Add unique field combo to match here
                        'player_id'   => $val['player_id'],
                    ], $fantasy_player_data);

                    //$this->info($model->name ." Bye week ". $model->bye_week);

                    //Create unique records for TQB & ST
                    if ($val['position'] == 'DEF') {
                        $valueHolder = '';
                        if ($val['player_id'] < 10) {
                            $valueHolder = '0';
                        }

                        //TQB
                        $tqbPlayerId = '2'.$valueHolder.$val['player_id'];
                        $tqb_fantasy_player_data = [
                            'fantasy_player_key'            =>$val['fantasy_player_key'].'_TQB',
                            'player_id'                     =>$tqbPlayerId,
                            'name'                          =>$val['name'],
                            'team'                          =>$val['team'],
                            'position'                      =>'TQB',
                            'average_draft_position'        =>$val['average_draft_position'],
                            'average_draft_position_p_p_r'  =>$val['average_draft_position_ppr'],
                            'bye_week'                      =>$val['bye_week'],
                            'last_season_fantasy_points'    =>$val['last_season_fantasy_points'],
                            'projected_fantasy_points'      =>$val['projected_fantasy_points'],
                            'auction_value'                 =>$val['auction_value'],
                            'auction_value_p_p_r'           =>$val['auction_value_ppr'],
                            'average_draft_position_id_p'   =>$val['average_draft_position_idp'],
                        ];

                        $model = \App\Models\FantasyData\FantasyPlayer::updateOrCreate([
                            //Add unique field combo to match here
                            'player_id'   => $tqbPlayerId,
                        ], $tqb_fantasy_player_data);

                        //ST
                        $stPlayerId = '3'.$valueHolder.$val['player_id'];
                        $st_fantasy_player_data = [
                            'fantasy_player_key'            =>$val['fantasy_player_key'].'_ST',
                            'player_id'                     =>$stPlayerId,
                            'name'                          =>$val['name'],
                            'team'                          =>$val['team'],
                            'position'                      =>'ST',
                            'average_draft_position'        =>$val['average_draft_position'],
                            'average_draft_position_p_p_r'  =>$val['average_draft_position_ppr'],
                            'bye_week'                      =>$val['bye_week'],
                            'last_season_fantasy_points'    =>$val['last_season_fantasy_points'],
                            'projected_fantasy_points'      =>$val['projected_fantasy_points'],
                            'auction_value'                 =>$val['auction_value'],
                            'auction_value_p_p_r'           =>$val['auction_value_ppr'],
                            'average_draft_position_id_p'   =>$val['average_draft_position_idp'],
                        ];

                        $model = \App\Models\FantasyData\FantasyPlayer::updateOrCreate([
                            //Add unique field combo to match here
                            'player_id'   => $stPlayerId,
                        ], $st_fantasy_player_data);

                        //$this->info($model->name ." Bye week ". $model->bye_week);
                    }
                }
                $this->info('Fantasy player details has been added/updated successfully');
            }
        } catch (Exception $e) {
            $this->error("Exception when calling api: ', $e->getMessage(), PHP_EOL");
        }
    }
}
