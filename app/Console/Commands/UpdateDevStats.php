<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateDevStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateDevStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update old stats from past seasons for players and teams.';

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
        $this->call('UpdateTimeframes', []);
        $this->call('UpdateTeams', []);
        $this->call('UpdateSchedules', []);
        $this->call('UpdateStandings', []);
        $this->call('UpdateFantasyPlayers', []);
        $this->call('GetNews', []);

        $this->call('UpdatePlayers', []);
        $this->call('UpdateStandings', []);
        $this->call('_UpdateProjections', []);

        $this->call('UpdateStats', []);
    }
}
