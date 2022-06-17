<?php

namespace App\Console\Commands;

use Helper;
use Illuminate\Console\Command;

class UpdateStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdateStats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $systemSettings = Helper::getSystemSettingsDetails();

        $this->call('UpdateFantasyDefenseSeasonStats', []);
        $this->call('UpdatePlayerSeasonStats', []);
        $this->call('UpdateTeamSeasonStats', []);
        $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--seasonTypeInt' => 1]);
        $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--seasonTypeInt' => 1]);
        $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--seasonTypeInt' => 1]);

        if ($systemSettings['season_type'] == 3) {
            $this->call('SyncPositionSeasonData', ['--position' => 'TQB', '--seasonTypeInt' => 3]);
            $this->call('SyncPositionSeasonData', ['--position' => 'ST', '--seasonTypeInt' => 3]);
            $this->call('CalculateFantasyPlayerSeasonFantasyPoints', ['--seasonTypeInt' => 3]);
        }
    }
}
