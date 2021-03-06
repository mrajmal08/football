<?php
/**
 * Schedule
 *
 * PHP version 5
 *
 * @category Class
 * @package  Acme\FantasyDataScores
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * NFL v3 Scores
 *
 * NFL schedules, scores, odds, weather, and news API.
 *
 * OpenAPI spec version: 1.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Acme\FantasyDataScores;

use \ArrayAccess;
use \Acme\FantasyDataScores\ObjectSerializer;

/**
 * Schedule Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataScores
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Schedule implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Schedule';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'game_key' => 'string',
        'season_type' => 'int',
        'season' => 'int',
        'week' => 'int',
        'date' => 'string',
        'away_team' => 'string',
        'home_team' => 'string',
        'channel' => 'string',
        'point_spread' => 'float',
        'over_under' => 'float',
        'stadium_id' => 'int',
        'canceled' => 'bool',
        'geo_lat' => 'float',
        'geo_long' => 'float',
        'forecast_temp_low' => 'int',
        'forecast_temp_high' => 'int',
        'forecast_description' => 'string',
        'forecast_wind_chill' => 'int',
        'forecast_wind_speed' => 'int',
        'away_team_money_line' => 'int',
        'home_team_money_line' => 'int',
        'day' => 'string',
        'date_time' => 'string',
        'global_game_id' => 'int',
        'global_away_team_id' => 'int',
        'global_home_team_id' => 'int',
        'score_id' => 'int',
        'stadium_details' => '\Acme\FantasyDataScores\\Stadium'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'game_key' => null,
        'season_type' => null,
        'season' => null,
        'week' => null,
        'date' => null,
        'away_team' => null,
        'home_team' => null,
        'channel' => null,
        'point_spread' => null,
        'over_under' => null,
        'stadium_id' => null,
        'canceled' => null,
        'geo_lat' => null,
        'geo_long' => null,
        'forecast_temp_low' => null,
        'forecast_temp_high' => null,
        'forecast_description' => null,
        'forecast_wind_chill' => null,
        'forecast_wind_speed' => null,
        'away_team_money_line' => null,
        'home_team_money_line' => null,
        'day' => null,
        'date_time' => null,
        'global_game_id' => null,
        'global_away_team_id' => null,
        'global_home_team_id' => null,
        'score_id' => null,
        'stadium_details' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'game_key' => 'GameKey',
        'season_type' => 'SeasonType',
        'season' => 'Season',
        'week' => 'Week',
        'date' => 'Date',
        'away_team' => 'AwayTeam',
        'home_team' => 'HomeTeam',
        'channel' => 'Channel',
        'point_spread' => 'PointSpread',
        'over_under' => 'OverUnder',
        'stadium_id' => 'StadiumID',
        'canceled' => 'Canceled',
        'geo_lat' => 'GeoLat',
        'geo_long' => 'GeoLong',
        'forecast_temp_low' => 'ForecastTempLow',
        'forecast_temp_high' => 'ForecastTempHigh',
        'forecast_description' => 'ForecastDescription',
        'forecast_wind_chill' => 'ForecastWindChill',
        'forecast_wind_speed' => 'ForecastWindSpeed',
        'away_team_money_line' => 'AwayTeamMoneyLine',
        'home_team_money_line' => 'HomeTeamMoneyLine',
        'day' => 'Day',
        'date_time' => 'DateTime',
        'global_game_id' => 'GlobalGameID',
        'global_away_team_id' => 'GlobalAwayTeamID',
        'global_home_team_id' => 'GlobalHomeTeamID',
        'score_id' => 'ScoreID',
        'stadium_details' => 'StadiumDetails'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'game_key' => 'setGameKey',
        'season_type' => 'setSeasonType',
        'season' => 'setSeason',
        'week' => 'setWeek',
        'date' => 'setDate',
        'away_team' => 'setAwayTeam',
        'home_team' => 'setHomeTeam',
        'channel' => 'setChannel',
        'point_spread' => 'setPointSpread',
        'over_under' => 'setOverUnder',
        'stadium_id' => 'setStadiumId',
        'canceled' => 'setCanceled',
        'geo_lat' => 'setGeoLat',
        'geo_long' => 'setGeoLong',
        'forecast_temp_low' => 'setForecastTempLow',
        'forecast_temp_high' => 'setForecastTempHigh',
        'forecast_description' => 'setForecastDescription',
        'forecast_wind_chill' => 'setForecastWindChill',
        'forecast_wind_speed' => 'setForecastWindSpeed',
        'away_team_money_line' => 'setAwayTeamMoneyLine',
        'home_team_money_line' => 'setHomeTeamMoneyLine',
        'day' => 'setDay',
        'date_time' => 'setDateTime',
        'global_game_id' => 'setGlobalGameId',
        'global_away_team_id' => 'setGlobalAwayTeamId',
        'global_home_team_id' => 'setGlobalHomeTeamId',
        'score_id' => 'setScoreId',
        'stadium_details' => 'setStadiumDetails'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'game_key' => 'getGameKey',
        'season_type' => 'getSeasonType',
        'season' => 'getSeason',
        'week' => 'getWeek',
        'date' => 'getDate',
        'away_team' => 'getAwayTeam',
        'home_team' => 'getHomeTeam',
        'channel' => 'getChannel',
        'point_spread' => 'getPointSpread',
        'over_under' => 'getOverUnder',
        'stadium_id' => 'getStadiumId',
        'canceled' => 'getCanceled',
        'geo_lat' => 'getGeoLat',
        'geo_long' => 'getGeoLong',
        'forecast_temp_low' => 'getForecastTempLow',
        'forecast_temp_high' => 'getForecastTempHigh',
        'forecast_description' => 'getForecastDescription',
        'forecast_wind_chill' => 'getForecastWindChill',
        'forecast_wind_speed' => 'getForecastWindSpeed',
        'away_team_money_line' => 'getAwayTeamMoneyLine',
        'home_team_money_line' => 'getHomeTeamMoneyLine',
        'day' => 'getDay',
        'date_time' => 'getDateTime',
        'global_game_id' => 'getGlobalGameId',
        'global_away_team_id' => 'getGlobalAwayTeamId',
        'global_home_team_id' => 'getGlobalHomeTeamId',
        'score_id' => 'getScoreId',
        'stadium_details' => 'getStadiumDetails'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['game_key'] = isset($data['game_key']) ? $data['game_key'] : null;
        $this->container['season_type'] = isset($data['season_type']) ? $data['season_type'] : null;
        $this->container['season'] = isset($data['season']) ? $data['season'] : null;
        $this->container['week'] = isset($data['week']) ? $data['week'] : null;
        $this->container['date'] = isset($data['date']) ? $data['date'] : null;
        $this->container['away_team'] = isset($data['away_team']) ? $data['away_team'] : null;
        $this->container['home_team'] = isset($data['home_team']) ? $data['home_team'] : null;
        $this->container['channel'] = isset($data['channel']) ? $data['channel'] : null;
        $this->container['point_spread'] = isset($data['point_spread']) ? $data['point_spread'] : null;
        $this->container['over_under'] = isset($data['over_under']) ? $data['over_under'] : null;
        $this->container['stadium_id'] = isset($data['stadium_id']) ? $data['stadium_id'] : null;
        $this->container['canceled'] = isset($data['canceled']) ? $data['canceled'] : null;
        $this->container['geo_lat'] = isset($data['geo_lat']) ? $data['geo_lat'] : null;
        $this->container['geo_long'] = isset($data['geo_long']) ? $data['geo_long'] : null;
        $this->container['forecast_temp_low'] = isset($data['forecast_temp_low']) ? $data['forecast_temp_low'] : null;
        $this->container['forecast_temp_high'] = isset($data['forecast_temp_high']) ? $data['forecast_temp_high'] : null;
        $this->container['forecast_description'] = isset($data['forecast_description']) ? $data['forecast_description'] : null;
        $this->container['forecast_wind_chill'] = isset($data['forecast_wind_chill']) ? $data['forecast_wind_chill'] : null;
        $this->container['forecast_wind_speed'] = isset($data['forecast_wind_speed']) ? $data['forecast_wind_speed'] : null;
        $this->container['away_team_money_line'] = isset($data['away_team_money_line']) ? $data['away_team_money_line'] : null;
        $this->container['home_team_money_line'] = isset($data['home_team_money_line']) ? $data['home_team_money_line'] : null;
        $this->container['day'] = isset($data['day']) ? $data['day'] : null;
        $this->container['date_time'] = isset($data['date_time']) ? $data['date_time'] : null;
        $this->container['global_game_id'] = isset($data['global_game_id']) ? $data['global_game_id'] : null;
        $this->container['global_away_team_id'] = isset($data['global_away_team_id']) ? $data['global_away_team_id'] : null;
        $this->container['global_home_team_id'] = isset($data['global_home_team_id']) ? $data['global_home_team_id'] : null;
        $this->container['score_id'] = isset($data['score_id']) ? $data['score_id'] : null;
        $this->container['stadium_details'] = isset($data['stadium_details']) ? $data['stadium_details'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {

        return true;
    }


    /**
     * Gets game_key
     *
     * @return string
     */
    public function getGameKey()
    {
        return $this->container['game_key'];
    }

    /**
     * Sets game_key
     *
     * @param string $game_key game_key
     *
     * @return $this
     */
    public function setGameKey($game_key)
    {
        $this->container['game_key'] = $game_key;

        return $this;
    }

    /**
     * Gets season_type
     *
     * @return int
     */
    public function getSeasonType()
    {
        return $this->container['season_type'];
    }

    /**
     * Sets season_type
     *
     * @param int $season_type season_type
     *
     * @return $this
     */
    public function setSeasonType($season_type)
    {
        $this->container['season_type'] = $season_type;

        return $this;
    }

    /**
     * Gets season
     *
     * @return int
     */
    public function getSeason()
    {
        return $this->container['season'];
    }

    /**
     * Sets season
     *
     * @param int $season season
     *
     * @return $this
     */
    public function setSeason($season)
    {
        $this->container['season'] = $season;

        return $this;
    }

    /**
     * Gets week
     *
     * @return int
     */
    public function getWeek()
    {
        return $this->container['week'];
    }

    /**
     * Sets week
     *
     * @param int $week week
     *
     * @return $this
     */
    public function setWeek($week)
    {
        $this->container['week'] = $week;

        return $this;
    }

    /**
     * Gets date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->container['date'];
    }

    /**
     * Sets date
     *
     * @param string $date date
     *
     * @return $this
     */
    public function setDate($date)
    {
        $this->container['date'] = $date;

        return $this;
    }

    /**
     * Gets away_team
     *
     * @return string
     */
    public function getAwayTeam()
    {
        return $this->container['away_team'];
    }

    /**
     * Sets away_team
     *
     * @param string $away_team away_team
     *
     * @return $this
     */
    public function setAwayTeam($away_team)
    {
        $this->container['away_team'] = $away_team;

        return $this;
    }

    /**
     * Gets home_team
     *
     * @return string
     */
    public function getHomeTeam()
    {
        return $this->container['home_team'];
    }

    /**
     * Sets home_team
     *
     * @param string $home_team home_team
     *
     * @return $this
     */
    public function setHomeTeam($home_team)
    {
        $this->container['home_team'] = $home_team;

        return $this;
    }

    /**
     * Gets channel
     *
     * @return string
     */
    public function getChannel()
    {
        return $this->container['channel'];
    }

    /**
     * Sets channel
     *
     * @param string $channel channel
     *
     * @return $this
     */
    public function setChannel($channel)
    {
        $this->container['channel'] = $channel;

        return $this;
    }

    /**
     * Gets point_spread
     *
     * @return float
     */
    public function getPointSpread()
    {
        return $this->container['point_spread'];
    }

    /**
     * Sets point_spread
     *
     * @param float $point_spread point_spread
     *
     * @return $this
     */
    public function setPointSpread($point_spread)
    {
        $this->container['point_spread'] = $point_spread;

        return $this;
    }

    /**
     * Gets over_under
     *
     * @return float
     */
    public function getOverUnder()
    {
        return $this->container['over_under'];
    }

    /**
     * Sets over_under
     *
     * @param float $over_under over_under
     *
     * @return $this
     */
    public function setOverUnder($over_under)
    {
        $this->container['over_under'] = $over_under;

        return $this;
    }

    /**
     * Gets stadium_id
     *
     * @return int
     */
    public function getStadiumId()
    {
        return $this->container['stadium_id'];
    }

    /**
     * Sets stadium_id
     *
     * @param int $stadium_id stadium_id
     *
     * @return $this
     */
    public function setStadiumId($stadium_id)
    {
        $this->container['stadium_id'] = $stadium_id;

        return $this;
    }

    /**
     * Gets canceled
     *
     * @return bool
     */
    public function getCanceled()
    {
        return $this->container['canceled'];
    }

    /**
     * Sets canceled
     *
     * @param bool $canceled canceled
     *
     * @return $this
     */
    public function setCanceled($canceled)
    {
        $this->container['canceled'] = $canceled;

        return $this;
    }

    /**
     * Gets geo_lat
     *
     * @return float
     */
    public function getGeoLat()
    {
        return $this->container['geo_lat'];
    }

    /**
     * Sets geo_lat
     *
     * @param float $geo_lat geo_lat
     *
     * @return $this
     */
    public function setGeoLat($geo_lat)
    {
        $this->container['geo_lat'] = $geo_lat;

        return $this;
    }

    /**
     * Gets geo_long
     *
     * @return float
     */
    public function getGeoLong()
    {
        return $this->container['geo_long'];
    }

    /**
     * Sets geo_long
     *
     * @param float $geo_long geo_long
     *
     * @return $this
     */
    public function setGeoLong($geo_long)
    {
        $this->container['geo_long'] = $geo_long;

        return $this;
    }

    /**
     * Gets forecast_temp_low
     *
     * @return int
     */
    public function getForecastTempLow()
    {
        return $this->container['forecast_temp_low'];
    }

    /**
     * Sets forecast_temp_low
     *
     * @param int $forecast_temp_low forecast_temp_low
     *
     * @return $this
     */
    public function setForecastTempLow($forecast_temp_low)
    {
        $this->container['forecast_temp_low'] = $forecast_temp_low;

        return $this;
    }

    /**
     * Gets forecast_temp_high
     *
     * @return int
     */
    public function getForecastTempHigh()
    {
        return $this->container['forecast_temp_high'];
    }

    /**
     * Sets forecast_temp_high
     *
     * @param int $forecast_temp_high forecast_temp_high
     *
     * @return $this
     */
    public function setForecastTempHigh($forecast_temp_high)
    {
        $this->container['forecast_temp_high'] = $forecast_temp_high;

        return $this;
    }

    /**
     * Gets forecast_description
     *
     * @return string
     */
    public function getForecastDescription()
    {
        return $this->container['forecast_description'];
    }

    /**
     * Sets forecast_description
     *
     * @param string $forecast_description forecast_description
     *
     * @return $this
     */
    public function setForecastDescription($forecast_description)
    {
        $this->container['forecast_description'] = $forecast_description;

        return $this;
    }

    /**
     * Gets forecast_wind_chill
     *
     * @return int
     */
    public function getForecastWindChill()
    {
        return $this->container['forecast_wind_chill'];
    }

    /**
     * Sets forecast_wind_chill
     *
     * @param int $forecast_wind_chill forecast_wind_chill
     *
     * @return $this
     */
    public function setForecastWindChill($forecast_wind_chill)
    {
        $this->container['forecast_wind_chill'] = $forecast_wind_chill;

        return $this;
    }

    /**
     * Gets forecast_wind_speed
     *
     * @return int
     */
    public function getForecastWindSpeed()
    {
        return $this->container['forecast_wind_speed'];
    }

    /**
     * Sets forecast_wind_speed
     *
     * @param int $forecast_wind_speed forecast_wind_speed
     *
     * @return $this
     */
    public function setForecastWindSpeed($forecast_wind_speed)
    {
        $this->container['forecast_wind_speed'] = $forecast_wind_speed;

        return $this;
    }

    /**
     * Gets away_team_money_line
     *
     * @return int
     */
    public function getAwayTeamMoneyLine()
    {
        return $this->container['away_team_money_line'];
    }

    /**
     * Sets away_team_money_line
     *
     * @param int $away_team_money_line away_team_money_line
     *
     * @return $this
     */
    public function setAwayTeamMoneyLine($away_team_money_line)
    {
        $this->container['away_team_money_line'] = $away_team_money_line;

        return $this;
    }

    /**
     * Gets home_team_money_line
     *
     * @return int
     */
    public function getHomeTeamMoneyLine()
    {
        return $this->container['home_team_money_line'];
    }

    /**
     * Sets home_team_money_line
     *
     * @param int $home_team_money_line home_team_money_line
     *
     * @return $this
     */
    public function setHomeTeamMoneyLine($home_team_money_line)
    {
        $this->container['home_team_money_line'] = $home_team_money_line;

        return $this;
    }

    /**
     * Gets day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->container['day'];
    }

    /**
     * Sets day
     *
     * @param string $day day
     *
     * @return $this
     */
    public function setDay($day)
    {
        $this->container['day'] = $day;

        return $this;
    }

    /**
     * Gets date_time
     *
     * @return string
     */
    public function getDateTime()
    {
        return $this->container['date_time'];
    }

    /**
     * Sets date_time
     *
     * @param string $date_time date_time
     *
     * @return $this
     */
    public function setDateTime($date_time)
    {
        $this->container['date_time'] = $date_time;

        return $this;
    }

    /**
     * Gets global_game_id
     *
     * @return int
     */
    public function getGlobalGameId()
    {
        return $this->container['global_game_id'];
    }

    /**
     * Sets global_game_id
     *
     * @param int $global_game_id global_game_id
     *
     * @return $this
     */
    public function setGlobalGameId($global_game_id)
    {
        $this->container['global_game_id'] = $global_game_id;

        return $this;
    }

    /**
     * Gets global_away_team_id
     *
     * @return int
     */
    public function getGlobalAwayTeamId()
    {
        return $this->container['global_away_team_id'];
    }

    /**
     * Sets global_away_team_id
     *
     * @param int $global_away_team_id global_away_team_id
     *
     * @return $this
     */
    public function setGlobalAwayTeamId($global_away_team_id)
    {
        $this->container['global_away_team_id'] = $global_away_team_id;

        return $this;
    }

    /**
     * Gets global_home_team_id
     *
     * @return int
     */
    public function getGlobalHomeTeamId()
    {
        return $this->container['global_home_team_id'];
    }

    /**
     * Sets global_home_team_id
     *
     * @param int $global_home_team_id global_home_team_id
     *
     * @return $this
     */
    public function setGlobalHomeTeamId($global_home_team_id)
    {
        $this->container['global_home_team_id'] = $global_home_team_id;

        return $this;
    }

    /**
     * Gets score_id
     *
     * @return int
     */
    public function getScoreId()
    {
        return $this->container['score_id'];
    }

    /**
     * Sets score_id
     *
     * @param int $score_id score_id
     *
     * @return $this
     */
    public function setScoreId($score_id)
    {
        $this->container['score_id'] = $score_id;

        return $this;
    }

    /**
     * Gets stadium_details
     *
     * @return \Acme\FantasyDataScores\\Stadium
     */
    public function getStadiumDetails()
    {
        return $this->container['stadium_details'];
    }

    /**
     * Sets stadium_details
     *
     * @param \Acme\FantasyDataScores\\Stadium $stadium_details stadium_details
     *
     * @return $this
     */
    public function setStadiumDetails($stadium_details)
    {
        $this->container['stadium_details'] = $stadium_details;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param  integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param  integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param  integer $offset Offset
     * @param  mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param  integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}

