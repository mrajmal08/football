<?php

namespace App\Console\Commands;

use App\Models\FantasyData\FantasyPlayer;
use App\Models\FantasyData\Team;
use Helper;
use Illuminate\Console\Command;

class SyncTqbAverageDraftPosition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SyncTqbAverageDraftPosition';

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
     * @return mixed
     */
    public function handle()
    {
        $qb_fantasy_player = FantasyPlayer::where('position', 'QB')
                                                    ->has('team')
                                                    ->OrderBy('average_draft_position')
                                                    ->get()
                                                    ->groupBy('team');

        $fantasy_player = FantasyPlayer::where('position', 'TQB')
                                                    ->get();
        foreach ($fantasy_player as $list) {
            $collection = collect($qb_fantasy_player[$list->team])->first();

            if ($collection) {
                $list->average_draft_position = $collection->average_draft_position;
                $list->save();
                $this->info('Set '.$list->name.' | '.$list->average_draft_position);
            } else {
                $this->info('DID NOT Set '.$list->name.' | '.$list->average_draft_position);
            }
        }
        $this->info('TQB Data Synced');
    }
}
