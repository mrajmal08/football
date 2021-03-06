<?php
/**
 * ScoringPlay
 *
 * PHP version 5
 *
 * @category Class
 * @package  Acme\FantasyDataStats
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * NFL v3 Stats
 *
 * NFL rosters, player stats, team stats, and fantasy stats API.
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

namespace Acme\FantasyDataStats;

use \ArrayAccess;
use \Acme\FantasyDataStats\ObjectSerializer;

/**
 * ScoringPlay Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class ScoringPlay implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'ScoringPlay';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'game_key' => 'string',
        'season_type' => 'int',
        'scoring_play_id' => 'int',
        'season' => 'int',
        'week' => 'int',
        'away_team' => 'string',
        'home_team' => 'string',
        'date' => 'string',
        'sequence' => 'int',
        'team' => 'string',
        'quarter' => 'string',
        'time_remaining' => 'string',
        'play_description' => 'string',
        'away_score' => 'int',
        'home_score' => 'int',
        'score_id' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'game_key' => null,
        'season_type' => null,
        'scoring_play_id' => null,
        'season' => null,
        'week' => null,
        'away_team' => null,
        'home_team' => null,
        'date' => null,
        'sequence' => null,
        'team' => null,
        'quarter' => null,
        'time_remaining' => null,
        'play_description' => null,
        'away_score' => null,
        'home_score' => null,
        'score_id' => null
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
        'scoring_play_id' => 'ScoringPlayID',
        'season' => 'Season',
        'week' => 'Week',
        'away_team' => 'AwayTeam',
        'home_team' => 'HomeTeam',
        'date' => 'Date',
        'sequence' => 'Sequence',
        'team' => 'Team',
        'quarter' => 'Quarter',
        'time_remaining' => 'TimeRemaining',
        'play_description' => 'PlayDescription',
        'away_score' => 'AwayScore',
        'home_score' => 'HomeScore',
        'score_id' => 'ScoreID'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'game_key' => 'setGameKey',
        'season_type' => 'setSeasonType',
        'scoring_play_id' => 'setScoringPlayId',
        'season' => 'setSeason',
        'week' => 'setWeek',
        'away_team' => 'setAwayTeam',
        'home_team' => 'setHomeTeam',
        'date' => 'setDate',
        'sequence' => 'setSequence',
        'team' => 'setTeam',
        'quarter' => 'setQuarter',
        'time_remaining' => 'setTimeRemaining',
        'play_description' => 'setPlayDescription',
        'away_score' => 'setAwayScore',
        'home_score' => 'setHomeScore',
        'score_id' => 'setScoreId'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'game_key' => 'getGameKey',
        'season_type' => 'getSeasonType',
        'scoring_play_id' => 'getScoringPlayId',
        'season' => 'getSeason',
        'week' => 'getWeek',
        'away_team' => 'getAwayTeam',
        'home_team' => 'getHomeTeam',
        'date' => 'getDate',
        'sequence' => 'getSequence',
        'team' => 'getTeam',
        'quarter' => 'getQuarter',
        'time_remaining' => 'getTimeRemaining',
        'play_description' => 'getPlayDescription',
        'away_score' => 'getAwayScore',
        'home_score' => 'getHomeScore',
        'score_id' => 'getScoreId'
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
        $this->container['scoring_play_id'] = isset($data['scoring_play_id']) ? $data['scoring_play_id'] : null;
        $this->container['season'] = isset($data['season']) ? $data['season'] : null;
        $this->container['week'] = isset($data['week']) ? $data['week'] : null;
        $this->container['away_team'] = isset($data['away_team']) ? $data['away_team'] : null;
        $this->container['home_team'] = isset($data['home_team']) ? $data['home_team'] : null;
        $this->container['date'] = isset($data['date']) ? $data['date'] : null;
        $this->container['sequence'] = isset($data['sequence']) ? $data['sequence'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['quarter'] = isset($data['quarter']) ? $data['quarter'] : null;
        $this->container['time_remaining'] = isset($data['time_remaining']) ? $data['time_remaining'] : null;
        $this->container['play_description'] = isset($data['play_description']) ? $data['play_description'] : null;
        $this->container['away_score'] = isset($data['away_score']) ? $data['away_score'] : null;
        $this->container['home_score'] = isset($data['home_score']) ? $data['home_score'] : null;
        $this->container['score_id'] = isset($data['score_id']) ? $data['score_id'] : null;
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
     * Gets scoring_play_id
     *
     * @return int
     */
    public function getScoringPlayId()
    {
        return $this->container['scoring_play_id'];
    }

    /**
     * Sets scoring_play_id
     *
     * @param int $scoring_play_id scoring_play_id
     *
     * @return $this
     */
    public function setScoringPlayId($scoring_play_id)
    {
        $this->container['scoring_play_id'] = $scoring_play_id;

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
     * Gets sequence
     *
     * @return int
     */
    public function getSequence()
    {
        return $this->container['sequence'];
    }

    /**
     * Sets sequence
     *
     * @param int $sequence sequence
     *
     * @return $this
     */
    public function setSequence($sequence)
    {
        $this->container['sequence'] = $sequence;

        return $this;
    }

    /**
     * Gets team
     *
     * @return string
     */
    public function getTeam()
    {
        return $this->container['team'];
    }

    /**
     * Sets team
     *
     * @param string $team team
     *
     * @return $this
     */
    public function setTeam($team)
    {
        $this->container['team'] = $team;

        return $this;
    }

    /**
     * Gets quarter
     *
     * @return string
     */
    public function getQuarter()
    {
        return $this->container['quarter'];
    }

    /**
     * Sets quarter
     *
     * @param string $quarter quarter
     *
     * @return $this
     */
    public function setQuarter($quarter)
    {
        $this->container['quarter'] = $quarter;

        return $this;
    }

    /**
     * Gets time_remaining
     *
     * @return string
     */
    public function getTimeRemaining()
    {
        return $this->container['time_remaining'];
    }

    /**
     * Sets time_remaining
     *
     * @param string $time_remaining time_remaining
     *
     * @return $this
     */
    public function setTimeRemaining($time_remaining)
    {
        $this->container['time_remaining'] = $time_remaining;

        return $this;
    }

    /**
     * Gets play_description
     *
     * @return string
     */
    public function getPlayDescription()
    {
        return $this->container['play_description'];
    }

    /**
     * Sets play_description
     *
     * @param string $play_description play_description
     *
     * @return $this
     */
    public function setPlayDescription($play_description)
    {
        $this->container['play_description'] = $play_description;

        return $this;
    }

    /**
     * Gets away_score
     *
     * @return int
     */
    public function getAwayScore()
    {
        return $this->container['away_score'];
    }

    /**
     * Sets away_score
     *
     * @param int $away_score away_score
     *
     * @return $this
     */
    public function setAwayScore($away_score)
    {
        $this->container['away_score'] = $away_score;

        return $this;
    }

    /**
     * Gets home_score
     *
     * @return int
     */
    public function getHomeScore()
    {
        return $this->container['home_score'];
    }

    /**
     * Sets home_score
     *
     * @param int $home_score home_score
     *
     * @return $this
     */
    public function setHomeScore($home_score)
    {
        $this->container['home_score'] = $home_score;

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

