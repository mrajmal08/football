<?php

namespace App\Console\Commands;

use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeagueGame;
use App\Models\LeagueSchedule;
use App\Models\LeagueScheduleSim;
use Helper;
use Illuminate\Console\Command;

class GenerateLeagueSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerateLeagueSchedules {--league_id=} {--week=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate league shedules';

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
        $this->info('Running GenerateLeagueSchedules');
        $week_options = $this->option('week');
        $league_id = $this->option('league_id');
        $systemSettings = Helper::getSystemSettingsDetails();
        try {
            if ($league_id) {
                $leagues = League::where('id', $league_id)->get();
            } else {
                $leagues = League::where('draft_completed', 1)->get();
            }
            if (! empty($leagues)) {
                $this->info('We have leagues GenerateLeagueSchedules');
                $this->info($leagues);
                foreach ($leagues as $key => $val) {
                    $this->info('inside foreach');
                    $this->info('Week: '.$week_options.' | Generate League Schedules for League ID: '.$val['id']);

                    // Delete week 15 games (and 7) if we are below week 16
                    if ($week_options == 7) {
                        // Delete old week 7 records
                        LeagueGame::where('week', 7)
                            ->where('year', $systemSettings['season'])
                            ->delete();

                        LeagueSchedule::where('league_id', $val['id'])
                            ->where('week', 7)
                            ->where('year', $systemSettings['season'])
                            ->delete();
                    }

                    if ($week_options == 15) {
                        // Delete old week 15 records
                        LeagueGame::where('week', 15)
                            ->where('year', $systemSettings['season'])
                            ->delete();

                        LeagueSchedule::where('league_id', $val['id'])
                            ->where('week', 15)
                            ->where('year', $systemSettings['season'])
                            ->delete();
                    }
                    for ($i = 1; $i <= 18; $i++) {
                        for ($j = 1; $j <= 6; $j++) {
                            $team_ranking = Helper::getLeagueCoachRatingRank($val['id']);
                            //Don't do week 16, 17, 18 games unless we say to via command.
                            if ($week_options < 16) {
                                if ($i == 1 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    }
                                }

                                if ($i == 2 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    }
                                }

                                if ($i == 3 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    }
                                }

                                if ($i == 4 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    }
                                }

                                if ($i == 5 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    }
                                }

                                if ($i == 6 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    }
                                }

                                if ($i == 7 && $week_options != 14) {
                                    if ($week_options == 7) {
                                        if ($j == 1) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        } elseif ($j == 2) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        } elseif ($j == 3) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        } elseif ($j == 4) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        } elseif ($j == 5) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        } elseif ($j == 6) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            $home_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                            $away_team_previous = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        }
                                    } else {
                                        if ($j == 1) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        } elseif ($j == 2) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        } elseif ($j == 3) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        } elseif ($j == 4) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        } elseif ($j == 5) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        } elseif ($j == 6) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        }
                                    }
                                }

                                if ($i == 8 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    }
                                }

                                if ($i == 9 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    }
                                }

                                if ($i == 10 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    }
                                }

                                if ($i == 11 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    }
                                }

                                if ($i == 12 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    }
                                }

                                if ($i == 13 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    }
                                }

                                if ($i == 14 && ! $week_options) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    }
                                }

                                if ($i == 15 && $week_options != 7) {
                                    if ($week_options == 15) {
                                        if ($j == 1) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);
                                        // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        } elseif ($j == 2) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                        // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        } elseif ($j == 3) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                        // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        } elseif ($j == 4) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                        // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        } elseif ($j == 5) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                        // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        } elseif ($j == 6) {
                                            $home_team = FantasyTeam::find($team_ranking[$j - 1]['home_team']);
                                            $away_team = FantasyTeam::find($team_ranking[$j - 1]['away_team']);

                                            // $home_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                            // $away_team_previous	=	FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        }
                                    } else {
                                        if ($j == 1) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        } elseif ($j == 2) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        } elseif ($j == 3) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        } elseif ($j == 4) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        } elseif ($j == 5) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        } elseif ($j == 6) {
                                            $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                            $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        }
                                    }
                                }

                                $home_team_id = $away_team_id = 0;
                                if (! empty($home_team)) {
                                    $home_team_id = $home_team->id;
                                }
                                if (! empty($away_team)) {
                                    $away_team_id = $away_team->id;
                                }

                                if ($home_team_id > 0 && $away_team_id > 0) {
                                    $league_data = [
                                        'home_team_id'		=>$home_team_id,
                                        'away_team_id'     	=>$away_team_id,
                                        'league_id'     	=>$val['id'],
                                        'week'     			=>$i,
                                        'year'     			=>$systemSettings['season'],
                                        'game_type_id'     	=>$systemSettings['season_type'],
                                        'week_game'     	=>null,
                                    ];

                                    if ($week_options == 7 || $week_options == 15) {
                                        if ($i == $week_options) {
                                            // $previous_home_team_id=$home_team_previous->id;
                                            // $previous_away_team_id=$away_team_previous->id;
                                            $result = \App\Models\LeagueSchedule::updateOrCreate(
                                                $league_data
                                            );
                                        }
                                    } else {
                                        if ($i != 16 && $i != 17 && $i != 18) {
                                            $result = \App\Models\LeagueSchedule::updateOrCreate(
                                                ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'game_type_id'=>'1'],
                                                $league_data
                                            );
                                        }
                                    }
                                }

                                //for LeagueScheduleSim
                                //Only run on initial run (i.e when we don't pass a week option)
                                if (! $week_options) {
                                    $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team_id)->get();

                                    if ($other_away_team) {
                                        foreach ($other_away_team as $list) {
                                            $league_sim_data = [
                                                'home_team_id'		=>$home_team_id,
                                                'away_team_id'     	=>$list->id,
                                                'league_id'     	=>$val['id'],
                                                'week'     			=>$i,
                                                'year'     			=>$systemSettings['season'],
                                                'game_type_id'     	=>1,
                                                'week_game'     	=>null,
                                            ];

                                            $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                $league_sim_data
                                            );
                                        }
                                    }

                                    $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team_id)->get();

                                    if ($other_away_team2) {
                                        foreach ($other_away_team2 as $list) {
                                            $league_sim_data = [
                                                'home_team_id'		=>$away_team_id,
                                                'away_team_id'     	=>$list->id,
                                                'league_id'     	=>$val['id'],
                                                'week'     			=>$i,
                                                'year'     			=>$systemSettings['season'],
                                                'game_type_id'     	=>1,
                                                'week_game'     	=>null,
                                            ];

                                            $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                $league_sim_data
                                            );
                                        }
                                    }
                                }
                            }
                            //For 16th week game schedule
                            elseif ($i == 16 && $week_options == 16) {
                                for ($j = 1; $j <= 12; $j++) {
                                    if ($j == 1) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $reg_season_tourn_type = 'division_playoff_north';
                                    } elseif ($j == 2) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $reg_season_tourn_type = 'division_playoff_north';
                                    } elseif ($j == 3) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                        $reg_season_tourn_type = 'division_playoff_north';
                                    } elseif ($j == 4) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $reg_season_tourn_type = 'division_playoff_south';
                                    } elseif ($j == 5) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $reg_season_tourn_type = 'division_playoff_south';
                                    } elseif ($j == 6) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                        $reg_season_tourn_type = 'division_playoff_south';
                                    } elseif ($j == 7) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $reg_season_tourn_type = 'division_playoff_west';
                                    } elseif ($j == 8) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $reg_season_tourn_type = 'division_playoff_west';
                                    } elseif ($j == 9) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                        $reg_season_tourn_type = 'division_playoff_west';
                                    } elseif ($j == 10) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $reg_season_tourn_type = 'division_playoff_east';
                                    } elseif ($j == 11) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        $reg_season_tourn_type = 'division_playoff_east';
                                    } elseif ($j == 12) {
                                        $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                        $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                        $reg_season_tourn_type = 'division_playoff_east';
                                    }

                                    $home_team_id = $away_team_id = 0;

                                    if (! empty($home_team)) {
                                        $home_team_id = $home_team->id;
                                    }

                                    if (! empty($away_team)) {
                                        $away_team_id = $away_team->id;
                                    }

                                    if ($home_team_id > 0 && $away_team_id > 0) {
                                        $league_data = [
                                            'home_team_id'		=>$home_team_id,
                                            'away_team_id'     	=>$away_team_id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type' =>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];
                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'game_type_id'=>1],
                                            $league_data
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team_id)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team_id)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }
                            }

                            //For 17th week game schedule
                            elseif ($i == 17 && $week_options == 17) {
                                $sixtenth_team_ranking = Helper::getDivisionTeamByRank($league = $val['id'], $week = 16);

                                //for 1st place teams
                                for ($j = 1; $j <= 2; $j++) {
                                    if ($j == 1) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][0]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][0]['id'];
                                        $reg_season_tourn_type = 'national_conference_championship';
                                    } elseif ($j == 2) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][0]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][0]['id'];
                                        $reg_season_tourn_type = 'american_conference_championship';
                                    }

                                    $home_team_id = $away_team_id = 0;
                                    if (! empty($home_team)) {
                                        $home_team_id = $home_team;
                                    }
                                    if (! empty($away_team)) {
                                        $away_team_id = $away_team;
                                    }

                                    if ($home_team_id > 0 && $away_team_id > 0) {
                                        $league_data = [
                                            'home_team_id'		=>$home_team_id,
                                            'away_team_id'     	=>$away_team_id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type'=>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=>$systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'game_type_id'=>1,
                                                'reg_season_tourn_type' =>$reg_season_tourn_type, ],
                                            $league_data
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team_id)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team_id)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }

                                //for LOSERS in NORTH Division VS SOUTH division
                                for ($j = 1; $j <= 6; $j++) {
                                    if ($j == 1) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    } elseif ($j == 2) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][1]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    } elseif ($j == 3) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    } elseif ($j == 4) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][2]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][1]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    } elseif ($j == 5) {
                                        $home_team = $sixtenth_team_ranking['NORTH DIVISION']['teams'][2]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    } elseif ($j == 6) {
                                        $home_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['SOUTH DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'national_conference_cons_round_1';
                                    }

                                    $home_team_id = $away_team_id = 0;
                                    if (! empty($home_team)) {
                                        $home_team_id = $home_team;
                                    }
                                    if (! empty($away_team)) {
                                        $away_team_id = $away_team;
                                    }

                                    if ($home_team_id > 0 && $away_team_id > 0) {
                                        $league_data = [
                                            'home_team_id'		=>$home_team_id,
                                            'away_team_id'     	=>$away_team_id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type'=>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'game_type_id'=>1, 'home_team_id' => $home_team_id, 'away_team_id' => $away_team_id, 'reg_season_tourn_type' =>$reg_season_tourn_type],
                                            $league_data
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team_id)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team_id)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }

                                //for LOSERS in EAST Division VS WEST  division
                                for ($j = 1; $j <= 6; $j++) {
                                    if ($j == 1) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    } elseif ($j == 2) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][1]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    } elseif ($j == 3) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    } elseif ($j == 4) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][2]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][1]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    } elseif ($j == 5) {
                                        $home_team = $sixtenth_team_ranking['EAST DIVISION']['teams'][2]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    } elseif ($j == 6) {
                                        $home_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][1]['id'];
                                        $away_team = $sixtenth_team_ranking['WEST DIVISION']['teams'][2]['id'];
                                        $reg_season_tourn_type = 'american_conference_cons_round_1';
                                    }

                                    $home_team_id = $away_team_id = 0;
                                    if (! empty($home_team)) {
                                        $home_team_id = $home_team;
                                    }
                                    if (! empty($away_team)) {
                                        $away_team_id = $away_team;
                                    }

                                    if ($home_team_id > 0 && $away_team_id > 0) {
                                        $league_data = [
                                            'home_team_id'		=>$home_team_id,
                                            'away_team_id'     	=>$away_team_id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type'=>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'game_type_id'=>'1', 'game_type_id'=>1, 'home_team_id' => $home_team_id, 'away_team_id' => $away_team_id, 'reg_season_tourn_type' =>$reg_season_tourn_type],
                                            $league_data
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team_id)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team_id)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team_id,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }
                            } elseif ($i == 18 && $week_options == 18) {
                                //dd($val['id']);
                                $result = Helper::getChampionshipFinals($val['id'], $week = 17);
                                //dd($result);

                                $national_win_team_id = $result['national_team'][0]['team_id'];
                                $national_loser_team_id = $result['national_team'][1]['team_id'];
                                $american_win_team_id = $result['american_team'][0]['team_id'];
                                $american_loser_team_id = $result['american_team'][1]['team_id'];

                                $league_data = [
                                    'home_team_id'		=>$national_win_team_id,
                                    'away_team_id'     	=>$american_win_team_id,
                                    'league_id'     	=>$val['id'],
                                    'week'     			=>$i,
                                    'year'     			=>$systemSettings['season'],
                                    'game_type_id'     	=>1,
                                    'reg_season_tourn_type'  =>'league_championship',
                                    'week_game'     	=>null,
                                ];
                                //dd($league_data);

                                $result = \App\Models\LeagueSchedule::updateOrCreate(
                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $national_win_team_id, 'away_team_id' => $american_win_team_id, 'game_type_id'=>1,
                                        'reg_season_tourn_type' =>'league_championship', ],
                                    $league_data
                                );

                                /******for LeagueScheduleSim***********/

                                $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $national_win_team_id)->get();

                                if ($other_away_team) {
                                    foreach ($other_away_team as $list) {
                                        $league_sim_data = [
                                            'home_team_id'		=>$national_win_team_id,
                                            'away_team_id'     	=>$list->id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $national_win_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                            $league_sim_data
                                        );
                                    }
                                }

                                $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $american_win_team_id)->get();

                                if ($other_away_team2) {
                                    foreach ($other_away_team2 as $list) {
                                        $league_sim_data = [
                                            'home_team_id'		=>$american_win_team_id,
                                            'away_team_id'     	=>$list->id,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                            ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $american_win_team_id, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                            $league_sim_data
                                        );
                                    }
                                }

                                /******for LeagueScheduleSim***********/

                                $national_conference = Helper::getNationalConference($league_id = $val['id'], $year = $systemSettings['season'], $week = 17);
                                $american_conference = Helper::getAmericanConference($league_id = $val['id'], $year = $systemSettings['season'], $week = 17);

                                $nationalConference_best_teams = array_values($national_conference);
                                $americanConference_best_teams = array_values($american_conference);

                                for ($j = 1; $j <= 15; $j++) {
                                    if ($j == 1) {
                                        $home_team = $national_loser_team_id;
                                        $away_team = $american_loser_team_id;
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 2) {
                                        $home_team = $national_loser_team_id;
                                        $away_team = $nationalConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 3) {
                                        $home_team = $national_loser_team_id;
                                        $away_team = $nationalConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 4) {
                                        $home_team = $national_loser_team_id;
                                        $away_team = $americanConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 5) {
                                        $home_team = $national_loser_team_id;
                                        $away_team = $americanConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 6) {
                                        $home_team = $american_loser_team_id;
                                        $away_team = $nationalConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 7) {
                                        $home_team = $american_loser_team_id;
                                        $away_team = $nationalConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 8) {
                                        $home_team = $american_loser_team_id;
                                        $away_team = $americanConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 9) {
                                        $home_team = $american_loser_team_id;
                                        $away_team = $americanConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 10) {
                                        $home_team = $nationalConference_best_teams[0]['team_id'];
                                        $away_team = $nationalConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 11) {
                                        $home_team = $nationalConference_best_teams[0]['team_id'];
                                        $away_team = $americanConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 12) {
                                        $home_team = $nationalConference_best_teams[0]['team_id'];
                                        $away_team = $americanConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 13) {
                                        $home_team = $nationalConference_best_teams[1]['team_id'];
                                        $away_team = $americanConference_best_teams[0]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 14) {
                                        $home_team = $nationalConference_best_teams[1]['team_id'];
                                        $away_team = $americanConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    } elseif ($j == 15) {
                                        $home_team = $americanConference_best_teams[0]['team_id'];
                                        $away_team = $americanConference_best_teams[1]['team_id'];
                                        $reg_season_tourn_type = 'cons_finals';
                                    }

                                    if ($home_team > 0 && $away_team > 0) {
                                        $league_data2 = [
                                            'home_team_id'		=>$home_team,
                                            'away_team_id'     	=>$away_team,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type'=>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   =>$val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'game_type_id'=>1, 'home_team_id' => $home_team, 'away_team_id' => $away_team, 'reg_season_tourn_type' =>$reg_season_tourn_type],
                                            $league_data2
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }
                                for ($j = 1; $j <= 6; $j++) {
                                    if ($j == 1) {
                                        $home_team = $nationalConference_best_teams[2]['team_id'];
                                        $away_team = $nationalConference_best_teams[3]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($j == 2) {
                                        $home_team = $nationalConference_best_teams[2]['team_id'];
                                        $away_team = $americanConference_best_teams[2]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($j == 3) {
                                        $home_team = $nationalConference_best_teams[2]['team_id'];
                                        $away_team = $americanConference_best_teams[3]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($j == 4) {
                                        $home_team = $nationalConference_best_teams[3]['team_id'];
                                        $away_team = $americanConference_best_teams[2]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($j == 5) {
                                        $home_team = $nationalConference_best_teams[3]['team_id'];
                                        $away_team = $americanConference_best_teams[3]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($j == 6) {
                                        $home_team = $americanConference_best_teams[2]['team_id'];
                                        $away_team = $americanConference_best_teams[3]['team_id'];
                                        $reg_season_tourn_type = 'toilet_bowl';
                                    }
                                    if ($home_team > 0 && $away_team > 0) {
                                        $league_data2 = [
                                            'home_team_id'		=>$home_team,
                                            'away_team_id'     	=>$away_team,
                                            'league_id'     	=>$val['id'],
                                            'week'     			=>$i,
                                            'year'     			=>$systemSettings['season'],
                                            'game_type_id'     	=>1,
                                            'reg_season_tourn_type'=>$reg_season_tourn_type,
                                            'week_game'     	=>null,
                                        ];

                                        $result = \App\Models\LeagueSchedule::updateOrCreate(
                                            ['league_id'   =>$val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'game_type_id'=>1, 'home_team_id' => $home_team, 'away_team_id' => $away_team, 'reg_season_tourn_type' =>$reg_season_tourn_type],
                                            $league_data2
                                        );

                                        /******for LeagueScheduleSim***********/

                                        $other_away_team = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $home_team)->get();

                                        if ($other_away_team) {
                                            foreach ($other_away_team as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$home_team,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $home_team, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        $other_away_team2 = FantasyTeam::where('league_id', $val['id'])->where('id', '!=', $away_team)->get();

                                        if ($other_away_team2) {
                                            foreach ($other_away_team2 as $list) {
                                                $league_sim_data = [
                                                    'home_team_id'		=>$away_team,
                                                    'away_team_id'     	=>$list->id,
                                                    'league_id'     	=>$val['id'],
                                                    'week'     			=>$i,
                                                    'year'     			=>$systemSettings['season'],
                                                    'game_type_id'     	=>1,
                                                    'week_game'     	=>null,
                                                ];

                                                $result = \App\Models\LeagueScheduleSim::updateOrCreate(
                                                    ['league_id'   => $val['id'], 'year'	=> $systemSettings['season'], 'week' => $i, 'home_team_id' => $away_team, 'away_team_id' => $list->id, 'game_type_id'=>1],
                                                    $league_sim_data
                                                );
                                            }
                                        }

                                        /******for LeagueScheduleSim***********/
                                    }
                                }
                            } else {
                                //Do nothing
                            }
                        }
                    }
                    $this->info('end foreach');
                }
                echo "League schedule details has been added successfully\r\n";
            } else {
                $this->info('We have no leagues GenerateLeagueSchedules');
            }
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }
}
