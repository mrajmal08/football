<?php
/**
 * Timeframe
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
 * Timeframe Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Timeframe implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Timeframe';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'season_type' => 'int',
        'season' => 'int',
        'week' => 'int',
        'name' => 'string',
        'short_name' => 'string',
        'start_date' => 'string',
        'end_date' => 'string',
        'first_game_start' => 'string',
        'first_game_end' => 'string',
        'last_game_end' => 'string',
        'has_games' => 'bool',
        'has_started' => 'bool',
        'has_ended' => 'bool',
        'has_first_game_started' => 'bool',
        'has_first_game_ended' => 'bool',
        'has_last_game_ended' => 'bool',
        'api_season' => 'string',
        'api_week' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'season_type' => null,
        'season' => null,
        'week' => null,
        'name' => null,
        'short_name' => null,
        'start_date' => null,
        'end_date' => null,
        'first_game_start' => null,
        'first_game_end' => null,
        'last_game_end' => null,
        'has_games' => null,
        'has_started' => null,
        'has_ended' => null,
        'has_first_game_started' => null,
        'has_first_game_ended' => null,
        'has_last_game_ended' => null,
        'api_season' => null,
        'api_week' => null
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
        'season_type' => 'SeasonType',
        'season' => 'Season',
        'week' => 'Week',
        'name' => 'Name',
        'short_name' => 'ShortName',
        'start_date' => 'StartDate',
        'end_date' => 'EndDate',
        'first_game_start' => 'FirstGameStart',
        'first_game_end' => 'FirstGameEnd',
        'last_game_end' => 'LastGameEnd',
        'has_games' => 'HasGames',
        'has_started' => 'HasStarted',
        'has_ended' => 'HasEnded',
        'has_first_game_started' => 'HasFirstGameStarted',
        'has_first_game_ended' => 'HasFirstGameEnded',
        'has_last_game_ended' => 'HasLastGameEnded',
        'api_season' => 'ApiSeason',
        'api_week' => 'ApiWeek'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'season_type' => 'setSeasonType',
        'season' => 'setSeason',
        'week' => 'setWeek',
        'name' => 'setName',
        'short_name' => 'setShortName',
        'start_date' => 'setStartDate',
        'end_date' => 'setEndDate',
        'first_game_start' => 'setFirstGameStart',
        'first_game_end' => 'setFirstGameEnd',
        'last_game_end' => 'setLastGameEnd',
        'has_games' => 'setHasGames',
        'has_started' => 'setHasStarted',
        'has_ended' => 'setHasEnded',
        'has_first_game_started' => 'setHasFirstGameStarted',
        'has_first_game_ended' => 'setHasFirstGameEnded',
        'has_last_game_ended' => 'setHasLastGameEnded',
        'api_season' => 'setApiSeason',
        'api_week' => 'setApiWeek'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'season_type' => 'getSeasonType',
        'season' => 'getSeason',
        'week' => 'getWeek',
        'name' => 'getName',
        'short_name' => 'getShortName',
        'start_date' => 'getStartDate',
        'end_date' => 'getEndDate',
        'first_game_start' => 'getFirstGameStart',
        'first_game_end' => 'getFirstGameEnd',
        'last_game_end' => 'getLastGameEnd',
        'has_games' => 'getHasGames',
        'has_started' => 'getHasStarted',
        'has_ended' => 'getHasEnded',
        'has_first_game_started' => 'getHasFirstGameStarted',
        'has_first_game_ended' => 'getHasFirstGameEnded',
        'has_last_game_ended' => 'getHasLastGameEnded',
        'api_season' => 'getApiSeason',
        'api_week' => 'getApiWeek'
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
        $this->container['season_type'] = isset($data['season_type']) ? $data['season_type'] : null;
        $this->container['season'] = isset($data['season']) ? $data['season'] : null;
        $this->container['week'] = isset($data['week']) ? $data['week'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['short_name'] = isset($data['short_name']) ? $data['short_name'] : null;
        $this->container['start_date'] = isset($data['start_date']) ? $data['start_date'] : null;
        $this->container['end_date'] = isset($data['end_date']) ? $data['end_date'] : null;
        $this->container['first_game_start'] = isset($data['first_game_start']) ? $data['first_game_start'] : null;
        $this->container['first_game_end'] = isset($data['first_game_end']) ? $data['first_game_end'] : null;
        $this->container['last_game_end'] = isset($data['last_game_end']) ? $data['last_game_end'] : null;
        $this->container['has_games'] = isset($data['has_games']) ? $data['has_games'] : null;
        $this->container['has_started'] = isset($data['has_started']) ? $data['has_started'] : null;
        $this->container['has_ended'] = isset($data['has_ended']) ? $data['has_ended'] : null;
        $this->container['has_first_game_started'] = isset($data['has_first_game_started']) ? $data['has_first_game_started'] : null;
        $this->container['has_first_game_ended'] = isset($data['has_first_game_ended']) ? $data['has_first_game_ended'] : null;
        $this->container['has_last_game_ended'] = isset($data['has_last_game_ended']) ? $data['has_last_game_ended'] : null;
        $this->container['api_season'] = isset($data['api_season']) ? $data['api_season'] : null;
        $this->container['api_week'] = isset($data['api_week']) ? $data['api_week'] : null;
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
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets short_name
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->container['short_name'];
    }

    /**
     * Sets short_name
     *
     * @param string $short_name short_name
     *
     * @return $this
     */
    public function setShortName($short_name)
    {
        $this->container['short_name'] = $short_name;

        return $this;
    }

    /**
     * Gets start_date
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->container['start_date'];
    }

    /**
     * Sets start_date
     *
     * @param string $start_date start_date
     *
     * @return $this
     */
    public function setStartDate($start_date)
    {
        $this->container['start_date'] = $start_date;

        return $this;
    }

    /**
     * Gets end_date
     *
     * @return string
     */
    public function getEndDate()
    {
        return $this->container['end_date'];
    }

    /**
     * Sets end_date
     *
     * @param string $end_date end_date
     *
     * @return $this
     */
    public function setEndDate($end_date)
    {
        $this->container['end_date'] = $end_date;

        return $this;
    }

    /**
     * Gets first_game_start
     *
     * @return string
     */
    public function getFirstGameStart()
    {
        return $this->container['first_game_start'];
    }

    /**
     * Sets first_game_start
     *
     * @param string $first_game_start first_game_start
     *
     * @return $this
     */
    public function setFirstGameStart($first_game_start)
    {
        $this->container['first_game_start'] = $first_game_start;

        return $this;
    }

    /**
     * Gets first_game_end
     *
     * @return string
     */
    public function getFirstGameEnd()
    {
        return $this->container['first_game_end'];
    }

    /**
     * Sets first_game_end
     *
     * @param string $first_game_end first_game_end
     *
     * @return $this
     */
    public function setFirstGameEnd($first_game_end)
    {
        $this->container['first_game_end'] = $first_game_end;

        return $this;
    }

    /**
     * Gets last_game_end
     *
     * @return string
     */
    public function getLastGameEnd()
    {
        return $this->container['last_game_end'];
    }

    /**
     * Sets last_game_end
     *
     * @param string $last_game_end last_game_end
     *
     * @return $this
     */
    public function setLastGameEnd($last_game_end)
    {
        $this->container['last_game_end'] = $last_game_end;

        return $this;
    }

    /**
     * Gets has_games
     *
     * @return bool
     */
    public function getHasGames()
    {
        return $this->container['has_games'];
    }

    /**
     * Sets has_games
     *
     * @param bool $has_games has_games
     *
     * @return $this
     */
    public function setHasGames($has_games)
    {
        $this->container['has_games'] = $has_games;

        return $this;
    }

    /**
     * Gets has_started
     *
     * @return bool
     */
    public function getHasStarted()
    {
        return $this->container['has_started'];
    }

    /**
     * Sets has_started
     *
     * @param bool $has_started has_started
     *
     * @return $this
     */
    public function setHasStarted($has_started)
    {
        $this->container['has_started'] = $has_started;

        return $this;
    }

    /**
     * Gets has_ended
     *
     * @return bool
     */
    public function getHasEnded()
    {
        return $this->container['has_ended'];
    }

    /**
     * Sets has_ended
     *
     * @param bool $has_ended has_ended
     *
     * @return $this
     */
    public function setHasEnded($has_ended)
    {
        $this->container['has_ended'] = $has_ended;

        return $this;
    }

    /**
     * Gets has_first_game_started
     *
     * @return bool
     */
    public function getHasFirstGameStarted()
    {
        return $this->container['has_first_game_started'];
    }

    /**
     * Sets has_first_game_started
     *
     * @param bool $has_first_game_started has_first_game_started
     *
     * @return $this
     */
    public function setHasFirstGameStarted($has_first_game_started)
    {
        $this->container['has_first_game_started'] = $has_first_game_started;

        return $this;
    }

    /**
     * Gets has_first_game_ended
     *
     * @return bool
     */
    public function getHasFirstGameEnded()
    {
        return $this->container['has_first_game_ended'];
    }

    /**
     * Sets has_first_game_ended
     *
     * @param bool $has_first_game_ended has_first_game_ended
     *
     * @return $this
     */
    public function setHasFirstGameEnded($has_first_game_ended)
    {
        $this->container['has_first_game_ended'] = $has_first_game_ended;

        return $this;
    }

    /**
     * Gets has_last_game_ended
     *
     * @return bool
     */
    public function getHasLastGameEnded()
    {
        return $this->container['has_last_game_ended'];
    }

    /**
     * Sets has_last_game_ended
     *
     * @param bool $has_last_game_ended has_last_game_ended
     *
     * @return $this
     */
    public function setHasLastGameEnded($has_last_game_ended)
    {
        $this->container['has_last_game_ended'] = $has_last_game_ended;

        return $this;
    }

    /**
     * Gets api_season
     *
     * @return string
     */
    public function getApiSeason()
    {
        return $this->container['api_season'];
    }

    /**
     * Sets api_season
     *
     * @param string $api_season api_season
     *
     * @return $this
     */
    public function setApiSeason($api_season)
    {
        $this->container['api_season'] = $api_season;

        return $this;
    }

    /**
     * Gets api_week
     *
     * @return string
     */
    public function getApiWeek()
    {
        return $this->container['api_week'];
    }

    /**
     * Sets api_week
     *
     * @param string $api_week api_week
     *
     * @return $this
     */
    public function setApiWeek($api_week)
    {
        $this->container['api_week'] = $api_week;

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
