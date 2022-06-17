<?php

namespace App\Console\Commands;

use App\Clients\FdClient;
use App\Models\SystemSetting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class GetNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetNews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the GetNews';

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
            $news = $apiInstance->news('json');
            if (! empty($news)) {
                foreach ($news as $key=>$val) {
                    if (! empty($val['player_id'])) {
                        $news_data = [
                            'news_id'					   =>$val['news_id'],
                            'source'     				   =>$val['source'],
                            'updated'     			       =>$val['updated'],
                            'time_ago'     			       =>$val['time_ago'],
                            'title'     				   =>$val['title'],
                            'content'     				   =>$val['content'],
                            'url'     				       =>$val['url'],
                            'terms_of_use'     			   =>$val['terms_of_use'],
                            'author'     			   	   =>$val['author'],
                            'categories'     			   =>$val['categories'],
                            'player_id'     			   =>$val['player_id'],
                            'team_id'     			   	   =>$val['team_id'],
                            'team'     			   		   =>$val['team'],
                            'player_id2'     			   =>$val['player_id2'],
                            'team_id2'     			  	   =>$val['team_id2'],
                            'team2'     			  	   =>$val['team2'],

                        ];

                        $model = \App\Models\FantasyData\News::updateOrCreate([
                            //Add unique field combo to match here
                            'news_id'   => $val['news_id'],
                        ], $news_data);
                    }
                }
                $this->info('News details has been added/updated successfully');
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
