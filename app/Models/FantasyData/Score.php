<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $table = 'score';

    protected $fillable = [
        'game_key',
        'season_type',
        'season',
        'week',
        'date',
        'away_team',
        'home_team',
        'away_score',
        'home_score',
        'channel',
        'point_spread',
        'over_under',
        'quarter',
        'time_remaining',
        'possession',
        'down',
        'distance',
        'yard_line',
        'yard_line_territory',
        'red_zone',
        'away_score_quarter1',
        'away_score_quarter2',
        'away_score_quarter3',
        'away_score_quarter4',
        'away_score_overtime',
        'home_score_quarter1',
        'home_score_quarter2',
        'home_score_quarter3',
        'home_score_quarter4',
        'home_score_overtime',
        'has_started',
        'is_in_progress',
        'is_over',
        'has1st_quarter_started',
        'has2nd_quarter_started',
        'has3rd_quarter_started',
        'has4th_quarter_started',
        'is_overtime',
        'down_and_distance',
        'quarter_description',
        'stadium_id',
        'last_updated',
        'geo_lat',
        'geo_long',
        'forecast_temp_low',
        'forecast_temp_high',
        'forecast_description',
        'forecast_wind_chill',
        'forecast_wind_speed',
        'away_team_money_line',
        'home_team_money_line',
        'canceled',
        'closed',
        'last_play',
        'day',
        'date_time',
        'away_team_id',
        'home_team_id',
        'global_game_id',
        'global_away_team_id',
        'global_home_team_id',
        'point_spread_away_team_money_line',
        'point_spread_home_team_money_line',
        'score_id',
    ];

    protected $casts = [
        'game_key' => 'string',
        'season_type' => 'integer',
        'season' => 'integer',
        'week' => 'integer',
        'date' => 'string',
        'away_team' => 'string',
        'home_team' => 'string',
        'away_score' => 'integer',
        'home_score' => 'integer',
        'channel' => 'string',
        'point_spread' => 'integer',
        'over_under' => 'integer',
        'quarter' => 'string',
        'time_remaining' => 'string',
        'possession' => 'string',
        'down' => 'integer',
        'distance' => 'string',
        'yard_line' => 'integer',
        'yard_line_territory' => 'string',
        'red_zone' => 'string',
        'away_score_quarter1' => 'integer',
        'away_score_quarter2' => 'integer',
        'away_score_quarter3' => 'integer',
        'away_score_quarter4' => 'integer',
        'away_score_overtime' => 'integer',
        'home_score_quarter1' => 'integer',
        'home_score_quarter2' => 'integer',
        'home_score_quarter3' => 'integer',
        'home_score_quarter4' => 'integer',
        'home_score_overtime' => 'integer',
        'has_started' => 'boolean',
        'is_in_progress' => 'boolean',
        'is_over' => 'boolean',
        'has1st_quarter_started' => 'boolean',
        'has2nd_quarter_started' => 'boolean',
        'has3rd_quarter_started' => 'boolean',
        'has4th_quarter_started' => 'boolean',
        'is_overtime' => 'boolean',
        'down_and_distance' => 'string',
        'quarter_description' => 'string',
        'stadium_id' => 'integer',
        'last_updated' => 'string',
        'geo_lat' => 'integer',
        'geo_long' => 'integer',
        'forecast_temp_low' => 'integer',
        'forecast_temp_high' => 'integer',
        'forecast_description' => 'string',
        'forecast_wind_chill' => 'integer',
        'forecast_wind_speed' => 'integer',
        'away_team_money_line' => 'integer',
        'home_team_money_line' => 'integer',
        'canceled' => 'boolean',
        'closed' => 'boolean',
        'last_play' => 'string',
        'day' => 'string',
        'date_time' => 'string',
        'away_team_id' => 'integer',
        'home_team_id' => 'integer',
        'global_game_id' => 'integer',
        'global_away_team_id' => 'integer',
        'global_home_team_id' => 'integer',
        'point_spread_away_team_money_line' => 'integer',
        'point_spread_home_team_money_line' => 'integer',
        'score_id' => 'integer',
    ];

    // protected $with = ['scoreStadium'];

    public function playerScore()
    {
        return $this->morphTo();
    }

    public function teamGame()
    {
        return $this->belongsTo(\App\Models\FantasyData\TeamGame::class, 'game_key', 'game_key');
    }

    public function scoreSchedule()
    {
        return $this->belongsTo(\App\Models\FantasyData\Schedule::class, 'game_key', 'game_key');
    }

    public function scorePlay()
    {
        return $this->hasMany(\App\Models\FantasyData\ScoringPlay::class, 'game_key', 'game_key');
    }

    public function scoreDetails()
    {
        return $this->hasMany(\App\Models\FantasyData\ScoringDetail::class, 'game_key', 'game_key');
    }

    public function scoreAwayTeam()
    {
        return $this->hasOne(\App\Models\FantasyData\Team::class, 'key', 'away_team');
    }

    public function scoreHomeTeam()
    {
        return $this->hasOne(\App\Models\FantasyData\Team::class, 'key', 'home_team');
    }

    public function scoreStadium()
    {
        return $this->hasOne(\App\Models\FantasyData\Stadium::class, 'stadium_id', 'stadium_id');
    }
}
