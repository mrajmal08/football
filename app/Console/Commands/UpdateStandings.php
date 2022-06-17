<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use App\Models\SystemSetting;
use Helper;
use Illuminate\Console\Command;

class UpdateStandings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateStandings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update standings';

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
        $season = $systemSettings['season'];
        //$season 	 = $this->ask('Please enter season');
        $apiInstance = new \Acme\FantasyDataScores\Api\DefaultApi(
                       new FdClient()
        );
        try {
            $result = $apiInstance->standings('json', $season);
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $standing_data = [
                        'season_type'			=>$val['season_type'],
                        'season'     			=>$val['season'],
                        'conference'     		=>$val['conference'],
                        'division'     			=>$val['division'],
                        'team'     				=>$val['team'],
                        'name'     				=>$val['name'],
                        'wins'     				=>$val['wins'],
                        'losses'     			=>$val['losses'],
                        'ties'     				=>$val['ties'],
                        'percentage'     		=>$val['percentage'],
                        'points_for'     		=>$val['points_for'],
                        'points_against'     	=>$val['points_against'],
                        'net_points'     	   	=>$val['net_points'],
                        'touchdowns'    		=>$val['touchdowns'],
                        'division_wins'     	=>$val['division_wins'],
                        'division_losses'     	=>$val['division_losses'],
                        'conference_wins'  	   	=>$val['conference_wins'],
                        'conference_losses'	   	=>$val['conference_losses'],
                        'team_id'     			=>$val['team_id'],
                    ];
                    $model = \App\Models\FantasyData\Standing::updateOrCreate(
                        ['season'   => $val['season'], 'season_type'	=> $val['season_type'], 'team_id' => $val['team_id']],
                        $standing_data
                    );
                }
                echo "Standing details has been added/updated successfully\r\n";
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
