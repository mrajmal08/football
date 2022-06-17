<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Mail;

class TestServices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'TestServices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the cron services';

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
        Mail::raw('Text to e-mail', function ($message) {
            $message->to('tylor@acmerealfantasyfootball.com');
            $message->subject('TestServices');
        });
    }
}
