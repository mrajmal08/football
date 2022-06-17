<?php

namespace App\Http\Controllers\Dev;

use Acme\FantasyDataStats\BoxScoreV3;
use Acme\FantasyDataStats\Player;
use Acme\FantasyDataStats\Schedule;
use Acme\FantasyDataStats\Timeframe;
use App\Clients\FdClient;
use App\Events\MyEvent;
use App\Http\Controllers\Controller;
use App\Models\FantasyTeam;
use App\Models\League;
use App\Models\LeagueSchedule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class DevController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        return view('dev.index');
    }

    /**
     * Show the draft room.
     *
     * @return Response
     */
    public function showDraftRoom()
    {
        return view('dev.draft-room');
    }

    public function phpinfo()
    {
        event(new MyEvent('hello world'));
    }

    /**
     * Show the league scoreboard.
     *
     * @return Response
     */
    public function showLeagueScoreboard()
    {
        return view('dev.league-scoreboard');
    }

    /**
     * Show the division screen.
     *
     * @return Response
     */
    public function showDivision()
    {
        return view('dev.division');
    }

    /**
     * Show the conference screen.
     *
     * @return Response
     */
    public function showConference()
    {
        return view('dev.conference');
    }

    /**
     * Show the live scoreboard screen.
     *
     * @return Response
     */
    public function showLiveGameScoreBoard()
    {
        return view('dev.live-game-scoreboard');
    }

    /**
     * Test FantasyData objects with dd
     *
     * @return Response
     */
    public function showFantasyDataObjectContainerInstantiated()
    {
        //$object = new Schedule();
        $object = new Player();
        dd($object);
    }

    /**
     * Test FantasyData API responses
     *
     * Info: https://github.com/swagger-api/swagger-codegen/tree/master/samples/client/petstore/php/SwaggerClient-php
     *
     * @return Response
     */
    public function showFantasyDataResponse()
    {
        /* $object = new Schedule();
        $apiInstance = new \Acme\FantasyDataStats\Api\DefaultApi(
            new FdClient()
        );

        $body = new BoxScoreV3(); // \Swagger\Client\Model\Client | client model*/

        $leagues = League::all();
        try {
            if (! empty($leagues)) {
                foreach ($leagues as $key=>$val) {
                    for ($i = 1; $i <= 14; $i++) {
                        for ($j = 1; $j <= 6; $j++) {
                            if ($i == 1) {
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

                            if ($i == 2) {
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

                            if ($i == 3) {
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

                            if ($i == 4) {
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

                            if ($i == 5) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
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

                            if ($i == 6) {
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

                            if ($i == 7) {
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

                            if ($i == 8) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                } elseif ($j == 2) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                } elseif ($j == 3) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                } elseif ($j == 4) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                } elseif ($j == 5) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                } elseif ($j == 6) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                }
                            }

                            if ($i == 9) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                } elseif ($j == 2) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                } elseif ($j == 3) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                } elseif ($j == 4) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                } elseif ($j == 5) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                } elseif ($j == 6) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                }
                            }

                            if ($i == 10) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                } elseif ($j == 2) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 6)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 4)->first();
                                } elseif ($j == 3) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 7)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                } elseif ($j == 4) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 11)->first();
                                } elseif ($j == 5) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 12)->first();
                                } elseif ($j == 6) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                }
                            }

                            if ($i == 11) {
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

                            if ($i == 12) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 10)->first();
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

                            if ($i == 13) {
                                if ($j == 1) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 1)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 9)->first();
                                } elseif ($j == 2) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 2)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 8)->first();
                                } elseif ($j == 3) {
                                    $home_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 3)->first();
                                    $away_team = FantasyTeam::where('league_id', $val['id'])->where('league_team_number', 5)->first();
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

                            if ($i == 14) {
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
                                    'year'     			=>'2018',
                                    'game_type_id'     	=>'2',
                                    'week_game'     	=>null,
                                ];

                                $result = \App\Models\LeagueSchedule::updateOrCreate(
                                    ['league_id'   => $val['id'], 'year'	=> '2018', 'week' => $i, 'home_team_id' => $home_team_id, 'away_team_id' => $away_team_id, 'game_type_id'=>'2'],
                                    $league_data
                                );
                            }
                        }
                    }
                }
            }

            /*  $format = 'json';
             $season = '2017POST';
             $week = 3;
             $playerstoinclude = 'all';
             $minutes = 999999;
             $hometeam = 'min';
             $result = $apiInstance->boxScoresVSimulation($format, 200);  */
            //$result = $apiInstance->boxScoresDeltaV($format, $season, $week, $playerstoinclude, $minutes);
            //$result = $apiInstance->legacyBoxScore($format, $season, $week, $hometeam);

            // $player_data=array(
            // 	'player_id'					       =>$result['player_id'],
            // 	'team'     					       =>$result['team'],
            // 	'first_name'     			       =>$result['first_name'],
            // 	'last_name'     			       =>$result['last_name'],
            // 	'position'     				       =>$result['position'],
            // 	'status'     				       =>$result['status'],
            // 	'height'     				       =>$result['height'],
            // 	'weight'     				       =>$result['weight'],
            // 	'birth_date'     			       =>$result['birth_date'],
            // 	'college'     				       =>$result['college'],
            // 	'fantasy_position'     		       =>$result['fantasy_position'],
            // 	'active'     				       =>$result['active'],
            // 	'position_category'     	   	   =>$result['position_category'],
            // 	'name'     	  					   =>$result['name'],
            // 	'age'     	 					   =>$result['age'],
            // 	'experience_string'     	       =>$result['experience_string'],
            // 	'birth_date_string'     		   =>$result['birth_date_string'],
            // 	'photo_url'     				   =>$result['photo_url'],
            // 	'bye_week'     				       =>$result['bye_week'],
            // 	'upcoming_game_opponent'     	   =>$result['upcoming_game_opponent'],
            // 	'upcoming_game_week'     		   =>$result['upcoming_game_week'],
            // 	'short_name'     				   =>$result['short_name'],
            // 	'average_draft_position'     	   =>$result['average_draft_position'],
            // 	'depth_position_category'     	   =>$result['depth_position_category'],
            // 	'depth_position'     			   =>$result['depth_position'],
            // 	'depth_display_order'     		   =>$result['depth_display_order'],
            // 	'current_team'     				   =>$result['current_team'],
            // 	'college_draft_team'     		   =>$result['college_draft_team'],
            // 	'college_draft_year'     		   =>$result['college_draft_year'],
            // 	'college_draft_round'     		   =>$result['college_draft_round'],
            // 	'college_draft_pick'     		   =>$result['college_draft_pick'],
            // 	'is_undrafted_free_agent'     	   =>$result['is_undrafted_free_agent'],
            // 	'height_feet'     				   =>$result['height_feet'],
            // 	'height_inches'     			   =>$result['height_inches'],
            // 	'upcoming_opponent_rank'     	   =>$result['upcoming_opponent_rank'],
            // 	'upcoming_opponent_position_rank'  =>$result['upcoming_opponent_position_rank'],
            // 	'current_status'     			   =>$result['current_status'],
            // 	'upcoming_salary'     			   =>$result['upcoming_salary'],
            // 	'fantasy_alarm_player_id'     	   =>$result['fantasy_alarm_player_id'],
            // 	'sport_radar_player_id'     	   =>$result['sport_radar_player_id'],
            // 	'rotoworld_player_id'     		   =>$result['rotoworld_player_id'],
            // 	'roto_wire_player_id'     		   =>$result['roto_wire_player_id'],
            // 	'stats_player_id'     			   =>$result['stats_player_id'],
            // 	'sports_direct_player_id'     	   =>$result['sports_direct_player_id'],
            // 	'xml_team_player_id'     		   =>$result['xml_team_player_id'],
            // 	'fan_duel_player_id'     		   =>$result['fan_duel_player_id'],
            // 	'draft_kings_player_id'     	   =>$result['draft_kings_player_id'],
            // 	'yahoo_player_id'     			   =>$result['yahoo_player_id'],
            // 	'injury_status'     			   =>$result['injury_status'],
            // 	'injury_body_part'     			   =>$result['injury_body_part'],
            // 	'injury_start_date'     		   =>$result['injury_start_date'],
            // 	'injury_notes'     				   =>$result['injury_notes'],
            // 	'fan_duel_name'     			   =>$result['fan_duel_name'],
            // 	'draft_kings_name'     			   =>$result['draft_kings_name'],
            // 	'yahoo_name'     				   =>$result['yahoo_name'],
            // 	'fantasy_position_depth_order'     =>$result['fantasy_position_depth_order'],
            // 	'injury_practice'     			   =>$result['injury_practice'],
            // 	'injury_practice_description'      =>$result['injury_practice_description'],
            // 	'declared_inactive'     		   =>$result['declared_inactive'],
            // 	'upcoming_fan_duel_salary'     	   =>$result['upcoming_fan_duel_salary'],
            // 	'upcoming_draft_kings_salary'      =>$result['upcoming_draft_kings_salary'],
            // 	'upcoming_yahoo_salary'     	   =>$result['upcoming_yahoo_salary'],
            // 	'team_id'     				       =>$result['team_id'],
            // 	'global_team_id'     		       =>$result['global_team_id'],
            // 	'fantasy_draft_player_id'          =>$result['fantasy_draft_player_id'],
            // 	'fantasy_draft_name'     		   =>$result['fantasy_draft_name']

            // );
            // $player = \App\Models\FantasyData\Player::updateOrCreate([
            // 	//Add unique field combo to match here
            // 	'player_id'   => $result['player_id'],
            // ],$player_data);

            //dd($result);
        } catch (Exception $e) {
            echo 'Exception when calling api: ', $e->getMessage(), PHP_EOL;
        }
    }

    /**
     * Show the countdown timer.
     *
     * @return Response
     */
    public function showCountdownTimer()
    {
        return view('dev.count-down-timer');
    }
}
