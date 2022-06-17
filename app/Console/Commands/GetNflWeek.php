<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use App\Models\SystemSetting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class GetNflWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetNflWeek';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To get NFL week settings';

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
        $apiInstance = new \Acme\FantasyDataStats\Api\DefaultApi(new FdClient());
        try {
            $week = $apiInstance->weekCurrent('json');
            if ($week != '') {
                $systemSettings = SystemSetting::find(1);
                if (! empty($systemSettings)) {
                    $systemSettings->week = $week;
                    $systemSettings->save();
                }
                $this->info('week updated successfully');
            } else {
                $this->info('No week details found');
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
