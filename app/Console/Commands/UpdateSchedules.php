<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class UpdateSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateSchedules  {--timeframe=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update schedules';

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
        $timeframe_options = $this->option('timeframe');
        $seasonTypeArray = Helper::getSystemSettingsDetails();
        $seasonVal = $seasonTypeArray['seasonVal'];
        if ($timeframe_options) {
            $seasonVal = $timeframe_options;
        }

        $apiInstance = new \Acme\FantasyDataScores\Api\DefaultApi(
                       new FdClient()
        );

        try {
            $result = $apiInstance->schedule('json', $seasonVal);
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $shedule_data = [
                        'game_key'				=>$val['game_key'],
                        'season_type'     		=>$val['season_type'],
                        'season'     			=>$val['season'],
                        'week'     			    =>$val['week'],
                        'date'     				=>$val['date'],
                        'away_team'     		=>$val['away_team'],
                        'home_team'     		=>$val['home_team'],
                        'channel'     			=>$val['channel'],
                        'point_spread'     		=>$val['point_spread'],
                        'over_under'     		=>$val['over_under'],
                        'stadium_id'     		=>$val['stadium_id'],
                        'canceled'     			=>$val['canceled'],
                        'geo_lat'     	   		=>$val['geo_lat'],
                        'geo_long'    			=>$val['geo_long'],
                        'forecast_temp_high'    =>$val['forecast_temp_high'],
                        'forecast_description'  =>$val['forecast_description'],
                        'forecast_wind_chill'   =>$val['forecast_wind_chill'],
                        'forecast_wind_speed'   =>$val['forecast_wind_speed'],
                        'away_team_money_line'  =>$val['away_team_money_line'],
                        'home_team_money_line'  =>$val['home_team_money_line'],
                        'day'     				=>$val['day'],
                        'date_time'     		=>$val['date_time'],
                        'global_game_id'     	=>$val['global_game_id'],
                        'global_away_team_id'   =>$val['global_away_team_id'],
                        'global_home_team_id'   =>$val['global_home_team_id'],
                        'score_id'     			=>$val['score_id'],
                    ];
                    $result = \App\Models\FantasyData\Schedule::updateOrCreate(
                        ['global_game_id'   => $val['global_game_id']],
                        $shedule_data
                    );
                }
                echo "Schedule details has been added/updated successfully\r\n";
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
