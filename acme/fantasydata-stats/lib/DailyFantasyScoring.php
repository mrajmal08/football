<?php
/**
 * DailyFantasyScoring
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
 * DailyFantasyScoring Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DailyFantasyScoring implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'DailyFantasyScoring';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'player_id' => 'int',
        'name' => 'string',
        'team' => 'string',
        'position' => 'string',
        'fantasy_points' => 'float',
        'fantasy_points_ppr' => 'float',
        'fantasy_points_fan_duel' => 'float',
        'fantasy_points_draft_kings' => 'float',
        'fantasy_points_yahoo' => 'float',
        'has_started' => 'bool',
        'is_in_progress' => 'bool',
        'is_over' => 'bool',
        'date' => 'string',
        'fantasy_points_fantasy_draft' => 'float'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'player_id' => null,
        'name' => null,
        'team' => null,
        'position' => null,
        'fantasy_points' => null,
        'fantasy_points_ppr' => null,
        'fantasy_points_fan_duel' => null,
        'fantasy_points_draft_kings' => null,
        'fantasy_points_yahoo' => null,
        'has_started' => null,
        'is_in_progress' => null,
        'is_over' => null,
        'date' => null,
        'fantasy_points_fantasy_draft' => null
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
        'player_id' => 'PlayerID',
        'name' => 'Name',
        'team' => 'Team',
        'position' => 'Position',
        'fantasy_points' => 'FantasyPoints',
        'fantasy_points_ppr' => 'FantasyPointsPPR',
        'fantasy_points_fan_duel' => 'FantasyPointsFanDuel',
        'fantasy_points_draft_kings' => 'FantasyPointsDraftKings',
        'fantasy_points_yahoo' => 'FantasyPointsYahoo',
        'has_started' => 'HasStarted',
        'is_in_progress' => 'IsInProgress',
        'is_over' => 'IsOver',
        'date' => 'Date',
        'fantasy_points_fantasy_draft' => 'FantasyPointsFantasyDraft'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'player_id' => 'setPlayerId',
        'name' => 'setName',
        'team' => 'setTeam',
        'position' => 'setPosition',
        'fantasy_points' => 'setFantasyPoints',
        'fantasy_points_ppr' => 'setFantasyPointsPpr',
        'fantasy_points_fan_duel' => 'setFantasyPointsFanDuel',
        'fantasy_points_draft_kings' => 'setFantasyPointsDraftKings',
        'fantasy_points_yahoo' => 'setFantasyPointsYahoo',
        'has_started' => 'setHasStarted',
        'is_in_progress' => 'setIsInProgress',
        'is_over' => 'setIsOver',
        'date' => 'setDate',
        'fantasy_points_fantasy_draft' => 'setFantasyPointsFantasyDraft'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'player_id' => 'getPlayerId',
        'name' => 'getName',
        'team' => 'getTeam',
        'position' => 'getPosition',
        'fantasy_points' => 'getFantasyPoints',
        'fantasy_points_ppr' => 'getFantasyPointsPpr',
        'fantasy_points_fan_duel' => 'getFantasyPointsFanDuel',
        'fantasy_points_draft_kings' => 'getFantasyPointsDraftKings',
        'fantasy_points_yahoo' => 'getFantasyPointsYahoo',
        'has_started' => 'getHasStarted',
        'is_in_progress' => 'getIsInProgress',
        'is_over' => 'getIsOver',
        'date' => 'getDate',
        'fantasy_points_fantasy_draft' => 'getFantasyPointsFantasyDraft'
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
        $this->container['player_id'] = isset($data['player_id']) ? $data['player_id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['fantasy_points'] = isset($data['fantasy_points']) ? $data['fantasy_points'] : null;
        $this->container['fantasy_points_ppr'] = isset($data['fantasy_points_ppr']) ? $data['fantasy_points_ppr'] : null;
        $this->container['fantasy_points_fan_duel'] = isset($data['fantasy_points_fan_duel']) ? $data['fantasy_points_fan_duel'] : null;
        $this->container['fantasy_points_draft_kings'] = isset($data['fantasy_points_draft_kings']) ? $data['fantasy_points_draft_kings'] : null;
        $this->container['fantasy_points_yahoo'] = isset($data['fantasy_points_yahoo']) ? $data['fantasy_points_yahoo'] : null;
        $this->container['has_started'] = isset($data['has_started']) ? $data['has_started'] : null;
        $this->container['is_in_progress'] = isset($data['is_in_progress']) ? $data['is_in_progress'] : null;
        $this->container['is_over'] = isset($data['is_over']) ? $data['is_over'] : null;
        $this->container['date'] = isset($data['date']) ? $data['date'] : null;
        $this->container['fantasy_points_fantasy_draft'] = isset($data['fantasy_points_fantasy_draft']) ? $data['fantasy_points_fantasy_draft'] : null;
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
     * Gets player_id
     *
     * @return int
     */
    public function getPlayerId()
    {
        return $this->container['player_id'];
    }

    /**
     * Sets player_id
     *
     * @param int $player_id player_id
     *
     * @return $this
     */
    public function setPlayerId($player_id)
    {
        $this->container['player_id'] = $player_id;

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
     * Gets position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->container['position'];
    }

    /**
     * Sets position
     *
     * @param string $position position
     *
     * @return $this
     */
    public function setPosition($position)
    {
        $this->container['position'] = $position;

        return $this;
    }

    /**
     * Gets fantasy_points
     *
     * @return float
     */
    public function getFantasyPoints()
    {
        return $this->container['fantasy_points'];
    }

    /**
     * Sets fantasy_points
     *
     * @param float $fantasy_points fantasy_points
     *
     * @return $this
     */
    public function setFantasyPoints($fantasy_points)
    {
        $this->container['fantasy_points'] = $fantasy_points;

        return $this;
    }

    /**
     * Gets fantasy_points_ppr
     *
     * @return float
     */
    public function getFantasyPointsPpr()
    {
        return $this->container['fantasy_points_ppr'];
    }

    /**
     * Sets fantasy_points_ppr
     *
     * @param float $fantasy_points_ppr fantasy_points_ppr
     *
     * @return $this
     */
    public function setFantasyPointsPpr($fantasy_points_ppr)
    {
        $this->container['fantasy_points_ppr'] = $fantasy_points_ppr;

        return $this;
    }

    /**
     * Gets fantasy_points_fan_duel
     *
     * @return float
     */
    public function getFantasyPointsFanDuel()
    {
        return $this->container['fantasy_points_fan_duel'];
    }

    /**
     * Sets fantasy_points_fan_duel
     *
     * @param float $fantasy_points_fan_duel fantasy_points_fan_duel
     *
     * @return $this
     */
    public function setFantasyPointsFanDuel($fantasy_points_fan_duel)
    {
        $this->container['fantasy_points_fan_duel'] = $fantasy_points_fan_duel;

        return $this;
    }

    /**
     * Gets fantasy_points_draft_kings
     *
     * @return float
     */
    public function getFantasyPointsDraftKings()
    {
        return $this->container['fantasy_points_draft_kings'];
    }

    /**
     * Sets fantasy_points_draft_kings
     *
     * @param float $fantasy_points_draft_kings fantasy_points_draft_kings
     *
     * @return $this
     */
    public function setFantasyPointsDraftKings($fantasy_points_draft_kings)
    {
        $this->container['fantasy_points_draft_kings'] = $fantasy_points_draft_kings;

        return $this;
    }

    /**
     * Gets fantasy_points_yahoo
     *
     * @return float
     */
    public function getFantasyPointsYahoo()
    {
        return $this->container['fantasy_points_yahoo'];
    }

    /**
     * Sets fantasy_points_yahoo
     *
     * @param float $fantasy_points_yahoo fantasy_points_yahoo
     *
     * @return $this
     */
    public function setFantasyPointsYahoo($fantasy_points_yahoo)
    {
        $this->container['fantasy_points_yahoo'] = $fantasy_points_yahoo;

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
     * Gets is_in_progress
     *
     * @return bool
     */
    public function getIsInProgress()
    {
        return $this->container['is_in_progress'];
    }

    /**
     * Sets is_in_progress
     *
     * @param bool $is_in_progress is_in_progress
     *
     * @return $this
     */
    public function setIsInProgress($is_in_progress)
    {
        $this->container['is_in_progress'] = $is_in_progress;

        return $this;
    }

    /**
     * Gets is_over
     *
     * @return bool
     */
    public function getIsOver()
    {
        return $this->container['is_over'];
    }

    /**
     * Sets is_over
     *
     * @param bool $is_over is_over
     *
     * @return $this
     */
    public function setIsOver($is_over)
    {
        $this->container['is_over'] = $is_over;

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
     * Gets fantasy_points_fantasy_draft
     *
     * @return float
     */
    public function getFantasyPointsFantasyDraft()
    {
        return $this->container['fantasy_points_fantasy_draft'];
    }

    /**
     * Sets fantasy_points_fantasy_draft
     *
     * @param float $fantasy_points_fantasy_draft fantasy_points_fantasy_draft
     *
     * @return $this
     */
    public function setFantasyPointsFantasyDraft($fantasy_points_fantasy_draft)
    {
        $this->container['fantasy_points_fantasy_draft'] = $fantasy_points_fantasy_draft;

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
