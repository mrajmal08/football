<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\User;
use Illuminate\Console\Command;
use Laravel\Spark\Spark;

class FillFantasyLeague extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'FillFantasyLeague';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To fill fantasy leagues';

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
        $inviteCode = $this->ask('Please enter invite code');
        $league = League::where('invite_code', 'LIKE', $inviteCode)->first();
        if (! empty($league)) {
            $teamCount = FantasyTeam::where('league_id', $league->id)->count();
            for ($i = $teamCount + 1; $i <= 12; $i++) {
                $password = 'password';
                $user = Spark::user();
                $user->forceFill([
                    'name' => 'Team '.$i,
                    'email' => 'team'.$i.'-'.$inviteCode.'@email.com',
                    'password' => bcrypt($password),
                ])->save();

                FantasyTeam::create([
                    'name' => 'Team '.$i,
                    'user_id' => $user->id,
                    'league_id' => $league->id,
                ]);
            }
            $this->info('Fantasy teams are created successfully.');
        } else {
            $this->error('No league found.');
        }
    }
}
