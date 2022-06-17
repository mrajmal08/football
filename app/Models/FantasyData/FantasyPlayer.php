<?php

namespace App\Models\FantasyData;

use Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FantasyPlayer extends Model
{
    use SoftDeletes;

    protected $table = 'fantasy_player';

    protected $appends = ['player_age', 'player_first_name', 'player_last_name', 'player_status', 'player_experience', 'player_fantasy_position', 'player_fantasy_draft_name', 'player_photo_url', 'player_average_draft_position', 'player_fantasy_position_depth_order', 'player_upcoming_game_opponent', 'player_upcoming_opponent_position_rank', 'player_upcoming_opponent_rank',
        //'player_current_week_fantasy_points_acme',
        'player_current_season_fantasy_points_acme', ];

    protected $fillable = [
        'fantasy_player_key',
        'player_id',
        'name',
        'team',
        'position',
        'average_draft_position',
        'average_draft_position_p_p_r',
        'bye_week',
        'last_season_fantasy_points',
        'projected_fantasy_points',
        'auction_value',
        'auction_value_p_p_r',
        'average_draft_position_id_p',
    ];

    protected $casts = [
        'fantasy_player_key' => 'string',
        'player_id' => 'integer',
        'name' => 'string',
        'team' => 'string',
        'position' => 'string',
        'average_draft_position' => 'integer',
        'average_draft_position_p_p_r' => 'integer',
        'bye_week' => 'integer',
        'last_season_fantasy_points' => 'integer',
        'projected_fantasy_points' => 'integer',
        'auction_value' => 'integer',
        'auction_value_p_p_r' => 'integer',
        'average_draft_position_id_p' => 'integer',
    ];

    // protected $with = ['fantasyPlayerNews'];

    public function player()
    {
        return $this->hasOne(\App\Models\FantasyData\Player::class, 'player_id', 'player_id')->withDefault();
    }

    public function team()
    {
        return $this->belongsTo(\App\Models\FantasyData\Team::class, 'team', 'key')->withDefault();
    }

    public function playerGame()
    {
        return $this->hasMany(\App\Models\FantasyData\PlayerGame::class, 'player_id', 'player_id');
    }

    public function currentPlayerGame()
    {
        // $systemSettings =   SystemSetting::find(1);
        //dd($systemSettings);
        // $season     =   array($systemSettings->season);
        // $seasonType = $systemSettings->season_type;
        // $week       =   $systemSettings->week;
        // $systemSeason = array($systemSettings->season);

        $systemSettings = Helper::getSystemSettingsDetails();
        $week = $systemSettings['week'];
        $season = $systemSettings['season'];
        $seasonType = $systemSettings['season_type'];

//        return $this->hasOne('App\Models\FantasyData\FantasyDefenseGame', 'player_id', 'player_id')
//            ->where('week', $week)
//            ->where('season', $season)
//            ->where('season_type', $seasonType);

        if ($this->player) {
            return $this->hasOne(\App\Models\FantasyData\PlayerGame::class, 'player_id', 'player_id')
                ->where('week', $week)
                ->where('season', $season)
                ->where('season_type', $seasonType);
        } else {
            return $this->hasOne(\App\Models\FantasyData\FantasyDefenseGame::class, 'player_id', 'player_id')
                ->where('week', $week)
                ->where('season', $season)
                ->where('season_type', $seasonType);
        }

        return $this->hasOne(\App\Models\FantasyData\PlayerGame::class, 'player_id', 'player_id')
            ->where('week', $week)
            ->where('season', $season)
            ->where('season_type', $seasonType);

//         return $this->playerGame()->latest();
        // return $this->playerGame()->withDefault();
    }

    public function teamGame()
    {
        return $this->hasOne(\App\Models\FantasyData\TeamGame::class, 'team', 'team');
        //     $systemSettings     = Helper::getSystemSettingsDetails();
    //     $week        =   $systemSettings['week'];
    //     $season      =   $systemSettings['season'];
    //     $seasonType  =   $systemSettings['season_type'];
    //     return $this->hasOne('App\Models\FantasyData\TeamGame', 'team', 'team')
    //         ->where('week', $week)
    //         ->where('season', $season)
    //         ->where('season_type', $seasonType);
    // }
    }

//    public function teamGame()
//    {
//        $systemSettings     = Helper::getSystemSettingsDetails();
//        $week        =   $systemSettings['week'];
//        $season      =   $systemSettings['season'];
//        $seasonType  =   $systemSettings['season_type'];
//        return $this->hasMany('App\Models\FantasyData\TeamGame', 'team', 'team')
//            ->where('week', $week)
//            ->where('season', $season)
//            ->where('season_type', $seasonType);
//    }

    /*public function tqbPlayerGame()
      {
          return $this->hasMany('App\Models\FantasyData\PlayerGame','team','team')
                     ->where('position','QB')
                      ->where('played', 1);
     }*/

    public function fantasyDefenseGame()
    {
        return $this->hasMany(\App\Models\FantasyData\FantasyDefenseGame::class, 'player_id', 'player_id');
    }

    public function playerSeason()
    {
        return $this->hasMany(\App\Models\FantasyData\PlayerSeason::class, 'player_id', 'player_id');
    }

    public function playerGameProjection()
    {
        return $this->hasMany(\App\Models\FantasyData\PlayerGameProjection::class, 'player_id', 'player_id');
    }

    public function playerSeasonProjection()
    {
        return $this->hasMany(\App\Models\FantasyData\PlayerSeasonProjection::class, 'player_id', 'player_id');
    }

    public function teamSeason()
    {
        return $this->hasMany(\App\Models\FantasyData\TeamSeason::class, 'team', 'team');
    }

    // public function gameFantasyPoint()
    //    {
    //        return $this->hasMany('App\Models\FantasyPlayerGameFantasyPoint','fantasy_player_id','id');
    //    }

    // public function seasonFantasyPoint()
    //    {
    //        return $this->hasMany('App\Models\FantasyPlayerSeasonFantasyPoint','fantasy_player_id','player_id');
    //    }

    public function fantasyDefenseSeason()
    {
        return $this->hasMany(\App\Models\FantasyData\FantasyDefenseSeason::class, 'player_id', 'player_id');
    }

    public function fantasyDefenseGameProjection()
    {
        return $this->hasMany(\App\Models\FantasyData\FantasyDefenseGameProjection::class, 'team', 'team');
    }

    public function fantasyDefenseSeasonProjection()
    {
        return $this->hasMany(\App\Models\FantasyData\FantasyDefenseSeasonProjection::class, 'team', 'team');
    }

    //**TODO: Remove this relation name.**/
    public function fantasyPlayerGameProjection()
    {
        return $this->hasMany(\App\Models\FantasyData\PlayerGameProjection::class, 'player_id', 'player_id');
    }

    public function fantasyPlayerNews()
    {
        return $this->hasMany(\App\Models\FantasyData\News::class, 'player_id', 'player_id')->orderBy('updated_at', 'desc');
    }

    //TODO: Update this to be more of a owned status
    public function fantasyTeamOwnedBy()
    {
        return $this->hasOne(\App\Models\FantasyTeamsRoster::class, 'fantasy_player_id', 'id')->withDefault(new class {
        });
//           ->where('active', 1)
//           ->orWhere('bench', 1)
//           ->withDefault(new class {
//           });

        // $systemSettings     = Helper::getSystemSettingsDetails();
        // $week        =   $systemSettings['week'];
        // $season      =   $systemSettings['season'];
        // $seasonType  =   $systemSettings['season_type'];

        // return $this->hasOne('App\Models\FantasyTeamsRoster', 'fantasy_player_id', 'id')
        //     ->where('week', $week)
        //     ->where('season', $season)
        //     ->where('season_type', $seasonType)
        //     ->where('active', 1)
        //     ->withDefault(new class {});
    }
    // public function teamRoster()
    // {
    //     $systemSettings		= Helper::getSystemSettingsDetails();
    //     $week		=	$systemSettings['week'];
    //     $season		=	$systemSettings['season'];
    //     $seasonType	=	$systemSettings['season_type'];
    //     return $this->hasOne('App\Models\FantasyTeamsRoster', 'fantasy_player_id', 'id')->where('week', $week)
    //                                                                           ->where('season', $season)
    //                                                                          ->where('season_type', $seasonType);
    // }

    public function getPlayerAgeAttribute()
    {
        if ($this->player) {
            return $this->player->age;
        }
    }

    public function getPlayerFirstNameAttribute()
    {
        if ($this->player) {
            return $this->player->first_name;
        } elseif ($this->teams) {
            return $this->teams->full_name;
        } else {
            return $this->name;
        }
    }

    public function getPlayerLastNameAttribute()
    {
        if ($this->player) {
            return $this->player->last_name;
        }
    }

    public function getPlayerStatusAttribute()
    {
        if ($this->player) {
            return $this->player->status;
        }
    }

    public function getPlayerExperienceAttribute()
    {
        if ($this->player) {
            return $this->player->experience;
        }
    }

    public function getPlayerFantasyPositionAttribute()
    {
        if ($this->player) {
            return $this->player->fantasy_position;
        } else {
            return $this->position;
        }
    }

    public function getPlayerFantasyDraftNameAttribute()
    {
        if ($this->player) {
            return $this->player->fantasy_draft_name;
        } elseif ($this->teams) {
            return $this->teams->fantasy_draft_name;
        }
    }

    public function getPlayerPhotoUrlAttribute()
    {
        if ($this->player) {
            return $this->player->photo_url;
        } elseif ($this->teams) {
            return $this->teams->wikipedia_logo_url;
        }
    }

    public function getPlayerAverageDraftPositionAttribute()
    {
        if ($this->player) {
            return $this->player->average_draft_position;
        } else {
            return $this->average_draft_position;
        }
    }

    public function getPlayerFantasyPositionDepthOrderAttribute()
    {
        if ($this->player) {
            return $this->player->fantasy_position_depth_order;
        }
    }

    public function getPlayerUpcomingGameOpponentAttribute()
    {
        if ($this->player && $this->player->upcoming_game_opponent) {
            return $this->player->upcoming_game_opponent;
        } elseif ($this->teams) {
            return $this->teams->upcoming_opponent;
        }
        // return \DB::table('team')->where('key', $this->team)->first()->upcoming_opponent;
    }

    public function getPlayerUpcomingOpponentPositionRankAttribute()
    {
        if ($this->player) {
            return $this->player->upcoming_opponent_position_rank;
        }
    }

    public function getPlayerUpcomingOpponentRankAttribute()
    {
        if ($this->player) {
            return $this->player->upcoming_opponent_rank;
        }
    }

    // public function getPlayerCurrentWeekFantasyPointsAcmeAttribute()
    // {
    //     if ($this->position == "DEF") {
    //         return isset($this->fantasyDefenseGame[0]->FantasyPlayerGameFantasyPoint[0]->fantasy_points) ? $this->fantasyDefenseGame[0]->FantasyPlayerGameFantasyPoint[0]->fantasy_points: 0.00;
    //     } else {
    //         // dd($this->fantasyDefenseGame[0]->FantasyPlayerGameFantasyPoint[0]->fantasy_points);
    //         return isset($this->playerGame[0]->FantasyPlayerGameFantasyPoint->fantasy_points) ? $this->playerGame[0]->FantasyPlayerGameFantasyPoint->fantasy_points: 0.00;
    //     }
    // }

    public function getPlayerCurrentSeasonFantasyPointsAcmeAttribute()
    {
        // if($this->playerSeason)
        //   return $this->playerSeason->fantasy_points_acme;
        // if($this->fantasyDefenseSeason)
        //   return $this->player->playerSeason->fantasy_points_acme;
        // //default
        return 0.00;
    }
}
