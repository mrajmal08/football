<?php

namespace App\Models\FantasyData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $table = 'schedule';

    protected $fillable = [
        'game_key',
        'season_type',
        'season',
        'week',
        'date',
        'away_team',
        'home_team',
        'channel',
        'point_spread',
        'over_under',
        'stadium_id',
        'canceled',
        'geo_lat',
        'geo_long',
        'forecast_temp_low',
        'forecast_temp_high',
        'forecast_description',
        'forecast_wind_chill',
        'forecast_wind_speed',
        'away_team_money_line',
        'home_team_money_line',
        'day',
        'date_time',
        'global_game_id',
        'global_away_team_id',
        'global_home_team_id',
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
        'channel' => 'string',
        'point_spread' => 'integer',
        'over_under' => 'integer',
        'stadium_id' => 'integer',
        'canceled' => 'boolean',
        'geo_lat' => 'integer',
        'geo_long' => 'integer',
        'forecast_temp_low' => 'integer',
        'forecast_temp_high' => 'integer',
        'forecast_description' => 'string',
        'forecast_wind_chill' => 'integer',
        'forecast_wind_speed' => 'integer',
        'away_team_money_line' => 'integer',
        'home_team_money_line' => 'integer',
        'day' => 'string',
        'date_time' => 'string',
        'global_game_id' => 'integer',
        'global_away_team_id' => 'integer',
        'global_home_team_id' => 'integer',
        'score_id' => 'integer',
    ];

    /**
     * Get the score.
     */
    public function scheduleScore()
    {
        return $this->hasOne(\App\Models\FantasyData\Score::class, 'game_key', 'game_key');
    }

    /**
     * Get the score.
     */
    public function scheduleAwayTeamRecord()
    {
        return $this->hasOne(\App\Models\FantasyData\Standing::class, 'team_id', 'global_away_team_id');
    }

    /**
     * Get the score.
     */
    public function scheduleHomeTeamRecord()
    {
        return $this->hasOne(\App\Models\FantasyData\Standing::class, 'team_id', 'global_home_team_id');
    }

    /**
     * Get the score.
     */
    public function scheduleHighlightedQBPlayer()
    {
        return $this->belongsTo(\App\Models\FantasyData\PlayerGame::class, 'game_key', 'game_key');
    }

    public function getDateAttribute($value)
    {
        return date('M d h:s A', strtotime($value));
    }
}
