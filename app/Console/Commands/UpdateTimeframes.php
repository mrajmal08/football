<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use Illuminate\Console\Command;

class UpdateTimeframes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateTimeframes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update timeframes';

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
            $result = $apiInstance->timeframes('json', 'recent');
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $timeframe_data = [
                        'season_type'				=>$val['season_type'],
                        'season'     				=>$val['season'],
                        'week'     			    	=>$val['week'],
                        'name'     			    	=>$val['name'],
                        'short_name'     			=>$val['short_name'],
                        'start_date'     			=>$val['start_date'],
                        'end_date'     				=>$val['end_date'],
                        'first_game_start'     		=>$val['first_game_start'],
                        'first_game_end'     		=>$val['first_game_end'],
                        'last_game_end'     		=>$val['last_game_end'],
                        'has_games'     			=>$val['has_games'],
                        'has_started'     			=>$val['has_started'],
                        'has_ended'     	   		=>$val['has_ended'],
                        'has_first_game_started'    =>$val['has_first_game_started'],
                        'has_first_game_ended'     	=>$val['has_first_game_ended'],
                        'has_last_game_ended'     	=>$val['has_last_game_ended'],
                        'api_season'     		   	=>$val['api_season'],
                        'api_week'     				=>$val['api_week'],
                    ];
                    $model = \App\Models\FantasyData\Timeframe::updateOrCreate(
                        ['api_season'   => $val['api_season'], 'api_week'	=> $val['api_week']],
                        $timeframe_data
                    );
                }
                echo "Timeframe details has been added/updated successfully\r\n";
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
