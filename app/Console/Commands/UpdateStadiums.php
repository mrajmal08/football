<?php

namespace App\Console\Commands;

use App\Clients\FdProjClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class UpdateStadiums extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateStadiums';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update stadiums';

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
        $apiInstance = new \Acme\FantasyDataScores\Api\DefaultApi(new FdProjClient());
        try {
            $result = $apiInstance->stadiums('json');
            if (! empty($result)) {
                foreach ($result as $key=>$val) {
                    $stadium_data = [
                        'stadium_id' 		=> $val['stadium_id'],
                        'name' 				=> $val['name'],
                        'city' 				=> $val['city'],
                        'state' 			=> $val['state'],
                        'country' 			=> $val['country'],
                        'capacity' 			=> $val['capacity'],
                        'playing_surface' 	=> $val['playing_surface'],
                        'geo_lat' 			=> $val['geo_lat'],
                        'geo_long' 			=> $val['geo_long'],
                    ];
                    $model = \App\Models\FantasyData\Stadium::updateOrCreate(
                        ['stadium_id'   => $val['stadium_id']],
                        $stadium_data
                    );
                }
                $this->info('Stadium details are inserted/updated successfully.');
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
