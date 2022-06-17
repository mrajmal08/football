<?php

namespace App\Jobs;

use App\Helpers\FantasyPointsHelper;
use App\Jobs\Exception;
use App\Models\FantasyData\FantasyPlayer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CalculateAcmeFantasyPointsByGame implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fantasyPlayer;

    protected $options;

    protected $isProjection;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($playerGame, $isProjection)
    {
        //Get the FantasyPlayer record for the player_id we were passed.
        // dd($playerGame);
        $fantasyPlayer = FantasyPlayer::where('player_id', $playerGame->player_id)->first();
        $options = (object) [];
        $options->week = $playerGame->week;
        $options->season = $playerGame->season;
        $options->seasonTypeInt = $playerGame->season_type;
        $options->isProjection = $isProjection;
        //$this->fantasyPlayer = $fantasyPlayer->withoutRelations();

        $this->fantasyPlayer = $fantasyPlayer;
        $this->options = $options;
        $this->isProjection = $isProjection;
        //Log::channel('slack_log')->info("Working on for ".$fantasyPlayer->name);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Log $log)
    {
        FantasyPointsHelper::calculateFantasyPlayerGameFantasyPoints(
            $this->options->week,
            $this->options->season,
            $this->options->seasonTypeInt,
            $this->fantasyPlayer,
            $this->options->isProjection
        );
    }

    public function failed($exception)
    {
        if ($this->isProjection) {
            Log::channel('slack_error')->error('Failed calculationg Projected Game Fantasy Points for '.$this->options->season.' Wk '.$this->options->week.'  | '.$this->fantasyPlayer->name);
        } else {
            Log::channel('slack_error')->error('Failed calculationg Real Game Fantasy Points for '.$this->options->season.' Wk '.$this->options->week.'  | '.$this->fantasyPlayer->name);
        }
    }
}
