<?php

namespace App\Console\Commands;

use App\Models\FantasyData\FantasyDefenseGameProjection;
use App\Models\FantasyData\PlayerGameProjection;
use App\Models\FantasyData\Schedule;
use Illuminate\Console\Command;

class CleanUpProjections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CleanUpProjections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup Deleted Projections';

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
        $canceledSchedules = Schedule::where('canceled', 1)->get();

        $gameKeys = $canceledSchedules->pluck('game_key');

        $toDelete = FantasyDefenseGameProjection::whereIn('game_key', $gameKeys)->delete();

        $toDelete = PlayerGameProjection::whereIn('game_key', $gameKeys)->delete();

        try {
        } catch (Exception $e) {
            echo 'Error during delete: ', $e->getMessage(), PHP_EOL;
        }
    }
}
