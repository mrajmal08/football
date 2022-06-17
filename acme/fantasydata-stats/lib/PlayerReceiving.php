<?php
/**
 * PlayerReceiving
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
 * PlayerReceiving Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PlayerReceiving implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'PlayerReceiving';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'player_game_id' => 'int',
        'player_id' => 'int',
        'short_name' => 'string',
        'name' => 'string',
        'team' => 'string',
        'number' => 'int',
        'position' => 'string',
        'position_category' => 'string',
        'fantasy_position' => 'string',
        'fantasy_points' => 'float',
        'updated' => 'string',
        'receptions' => 'int',
        'receiving_targets' => 'int',
        'receiving_yards' => 'int',
        'receiving_touchdowns' => 'int',
        'receiving_long' => 'int',
        'receiving_yards_per_reception' => 'float',
        'receiving_yards_per_target' => 'float',
        'reception_percentage' => 'float',
        'fumbles_lost' => 'int',
        'two_point_conversion_receptions' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'player_game_id' => null,
        'player_id' => null,
        'short_name' => null,
        'name' => null,
        'team' => null,
        'number' => null,
        'position' => null,
        'position_category' => null,
        'fantasy_position' => null,
        'fantasy_points' => null,
        'updated' => null,
        'receptions' => null,
        'receiving_targets' => null,
        'receiving_yards' => null,
        'receiving_touchdowns' => null,
        'receiving_long' => null,
        'receiving_yards_per_reception' => null,
        'receiving_yards_per_target' => null,
        'reception_percentage' => null,
        'fumbles_lost' => null,
        'two_point_conversion_receptions' => null
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
        'player_game_id' => 'PlayerGameID',
        'player_id' => 'PlayerID',
        'short_name' => 'ShortName',
        'name' => 'Name',
        'team' => 'Team',
        'number' => 'Number',
        'position' => 'Position',
        'position_category' => 'PositionCategory',
        'fantasy_position' => 'FantasyPosition',
        'fantasy_points' => 'FantasyPoints',
        'updated' => 'Updated',
        'receptions' => 'Receptions',
        'receiving_targets' => 'ReceivingTargets',
        'receiving_yards' => 'ReceivingYards',
        'receiving_touchdowns' => 'ReceivingTouchdowns',
        'receiving_long' => 'ReceivingLong',
        'receiving_yards_per_reception' => 'ReceivingYardsPerReception',
        'receiving_yards_per_target' => 'ReceivingYardsPerTarget',
        'reception_percentage' => 'ReceptionPercentage',
        'fumbles_lost' => 'FumblesLost',
        'two_point_conversion_receptions' => 'TwoPointConversionReceptions'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'player_game_id' => 'setPlayerGameId',
        'player_id' => 'setPlayerId',
        'short_name' => 'setShortName',
        'name' => 'setName',
        'team' => 'setTeam',
        'number' => 'setNumber',
        'position' => 'setPosition',
        'position_category' => 'setPositionCategory',
        'fantasy_position' => 'setFantasyPosition',
        'fantasy_points' => 'setFantasyPoints',
        'updated' => 'setUpdated',
        'receptions' => 'setReceptions',
        'receiving_targets' => 'setReceivingTargets',
        'receiving_yards' => 'setReceivingYards',
        'receiving_touchdowns' => 'setReceivingTouchdowns',
        'receiving_long' => 'setReceivingLong',
        'receiving_yards_per_reception' => 'setReceivingYardsPerReception',
        'receiving_yards_per_target' => 'setReceivingYardsPerTarget',
        'reception_percentage' => 'setReceptionPercentage',
        'fumbles_lost' => 'setFumblesLost',
        'two_point_conversion_receptions' => 'setTwoPointConversionReceptions'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'player_game_id' => 'getPlayerGameId',
        'player_id' => 'getPlayerId',
        'short_name' => 'getShortName',
        'name' => 'getName',
        'team' => 'getTeam',
        'number' => 'getNumber',
        'position' => 'getPosition',
        'position_category' => 'getPositionCategory',
        'fantasy_position' => 'getFantasyPosition',
        'fantasy_points' => 'getFantasyPoints',
        'updated' => 'getUpdated',
        'receptions' => 'getReceptions',
        'receiving_targets' => 'getReceivingTargets',
        'receiving_yards' => 'getReceivingYards',
        'receiving_touchdowns' => 'getReceivingTouchdowns',
        'receiving_long' => 'getReceivingLong',
        'receiving_yards_per_reception' => 'getReceivingYardsPerReception',
        'receiving_yards_per_target' => 'getReceivingYardsPerTarget',
        'reception_percentage' => 'getReceptionPercentage',
        'fumbles_lost' => 'getFumblesLost',
        'two_point_conversion_receptions' => 'getTwoPointConversionReceptions'
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
        $this->container['player_game_id'] = isset($data['player_game_id']) ? $data['player_game_id'] : null;
        $this->container['player_id'] = isset($data['player_id']) ? $data['player_id'] : null;
        $this->container['short_name'] = isset($data['short_name']) ? $data['short_name'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['number'] = isset($data['number']) ? $data['number'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['position_category'] = isset($data['position_category']) ? $data['position_category'] : null;
        $this->container['fantasy_position'] = isset($data['fantasy_position']) ? $data['fantasy_position'] : null;
        $this->container['fantasy_points'] = isset($data['fantasy_points']) ? $data['fantasy_points'] : null;
        $this->container['updated'] = isset($data['updated']) ? $data['updated'] : null;
        $this->container['receptions'] = isset($data['receptions']) ? $data['receptions'] : null;
        $this->container['receiving_targets'] = isset($data['receiving_targets']) ? $data['receiving_targets'] : null;
        $this->container['receiving_yards'] = isset($data['receiving_yards']) ? $data['receiving_yards'] : null;
        $this->container['receiving_touchdowns'] = isset($data['receiving_touchdowns']) ? $data['receiving_touchdowns'] : null;
        $this->container['receiving_long'] = isset($data['receiving_long']) ? $data['receiving_long'] : null;
        $this->container['receiving_yards_per_reception'] = isset($data['receiving_yards_per_reception']) ? $data['receiving_yards_per_reception'] : null;
        $this->container['receiving_yards_per_target'] = isset($data['receiving_yards_per_target']) ? $data['receiving_yards_per_target'] : null;
        $this->container['reception_percentage'] = isset($data['reception_percentage']) ? $data['reception_percentage'] : null;
        $this->container['fumbles_lost'] = isset($data['fumbles_lost']) ? $data['fumbles_lost'] : null;
        $this->container['two_point_conversion_receptions'] = isset($data['two_point_conversion_receptions']) ? $data['two_point_conversion_receptions'] : null;
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
     * Gets player_game_id
     *
     * @return int
     */
    public function getPlayerGameId()
    {
        return $this->container['player_game_id'];
    }

    /**
     * Sets player_game_id
     *
     * @param int $player_game_id player_game_id
     *
     * @return $this
     */
    public function setPlayerGameId($player_game_id)
    {
        $this->container['player_game_id'] = $player_game_id;

        return $this;
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
     * Gets number
     *
     * @return int
     */
    public function getNumber()
    {
        return $this->container['number'];
    }

    /**
     * Sets number
     *
     * @param int $number number
     *
     * @return $this
     */
    public function setNumber($number)
    {
        $this->container['number'] = $number;

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
     * Gets position_category
     *
     * @return string
     */
    public function getPositionCategory()
    {
        return $this->container['position_category'];
    }

    /**
     * Sets position_category
     *
     * @param string $position_category position_category
     *
     * @return $this
     */
    public function setPositionCategory($position_category)
    {
        $this->container['position_category'] = $position_category;

        return $this;
    }

    /**
     * Gets fantasy_position
     *
     * @return string
     */
    public function getFantasyPosition()
    {
        return $this->container['fantasy_position'];
    }

    /**
     * Sets fantasy_position
     *
     * @param string $fantasy_position fantasy_position
     *
     * @return $this
     */
    public function setFantasyPosition($fantasy_position)
    {
        $this->container['fantasy_position'] = $fantasy_position;

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
     * Gets updated
     *
     * @return string
     */
    public function getUpdated()
    {
        return $this->container['updated'];
    }

    /**
     * Sets updated
     *
     * @param string $updated updated
     *
     * @return $this
     */
    public function setUpdated($updated)
    {
        $this->container['updated'] = $updated;

        return $this;
    }

    /**
     * Gets receptions
     *
     * @return int
     */
    public function getReceptions()
    {
        return $this->container['receptions'];
    }

    /**
     * Sets receptions
     *
     * @param int $receptions receptions
     *
     * @return $this
     */
    public function setReceptions($receptions)
    {
        $this->container['receptions'] = $receptions;

        return $this;
    }

    /**
     * Gets receiving_targets
     *
     * @return int
     */
    public function getReceivingTargets()
    {
        return $this->container['receiving_targets'];
    }

    /**
     * Sets receiving_targets
     *
     * @param int $receiving_targets receiving_targets
     *
     * @return $this
     */
    public function setReceivingTargets($receiving_targets)
    {
        $this->container['receiving_targets'] = $receiving_targets;

        return $this;
    }

    /**
     * Gets receiving_yards
     *
     * @return int
     */
    public function getReceivingYards()
    {
        return $this->container['receiving_yards'];
    }

    /**
     * Sets receiving_yards
     *
     * @param int $receiving_yards receiving_yards
     *
     * @return $this
     */
    public function setReceivingYards($receiving_yards)
    {
        $this->container['receiving_yards'] = $receiving_yards;

        return $this;
    }

    /**
     * Gets receiving_touchdowns
     *
     * @return int
     */
    public function getReceivingTouchdowns()
    {
        return $this->container['receiving_touchdowns'];
    }

    /**
     * Sets receiving_touchdowns
     *
     * @param int $receiving_touchdowns receiving_touchdowns
     *
     * @return $this
     */
    public function setReceivingTouchdowns($receiving_touchdowns)
    {
        $this->container['receiving_touchdowns'] = $receiving_touchdowns;

        return $this;
    }

    /**
     * Gets receiving_long
     *
     * @return int
     */
    public function getReceivingLong()
    {
        return $this->container['receiving_long'];
    }

    /**
     * Sets receiving_long
     *
     * @param int $receiving_long receiving_long
     *
     * @return $this
     */
    public function setReceivingLong($receiving_long)
    {
        $this->container['receiving_long'] = $receiving_long;

        return $this;
    }

    /**
     * Gets receiving_yards_per_reception
     *
     * @return float
     */
    public function getReceivingYardsPerReception()
    {
        return $this->container['receiving_yards_per_reception'];
    }

    /**
     * Sets receiving_yards_per_reception
     *
     * @param float $receiving_yards_per_reception receiving_yards_per_reception
     *
     * @return $this
     */
    public function setReceivingYardsPerReception($receiving_yards_per_reception)
    {
        $this->container['receiving_yards_per_reception'] = $receiving_yards_per_reception;

        return $this;
    }

    /**
     * Gets receiving_yards_per_target
     *
     * @return float
     */
    public function getReceivingYardsPerTarget()
    {
        return $this->container['receiving_yards_per_target'];
    }

    /**
     * Sets receiving_yards_per_target
     *
     * @param float $receiving_yards_per_target receiving_yards_per_target
     *
     * @return $this
     */
    public function setReceivingYardsPerTarget($receiving_yards_per_target)
    {
        $this->container['receiving_yards_per_target'] = $receiving_yards_per_target;

        return $this;
    }

    /**
     * Gets reception_percentage
     *
     * @return float
     */
    public function getReceptionPercentage()
    {
        return $this->container['reception_percentage'];
    }

    /**
     * Sets reception_percentage
     *
     * @param float $reception_percentage reception_percentage
     *
     * @return $this
     */
    public function setReceptionPercentage($reception_percentage)
    {
        $this->container['reception_percentage'] = $reception_percentage;

        return $this;
    }

    /**
     * Gets fumbles_lost
     *
     * @return int
     */
    public function getFumblesLost()
    {
        return $this->container['fumbles_lost'];
    }

    /**
     * Sets fumbles_lost
     *
     * @param int $fumbles_lost fumbles_lost
     *
     * @return $this
     */
    public function setFumblesLost($fumbles_lost)
    {
        $this->container['fumbles_lost'] = $fumbles_lost;

        return $this;
    }

    /**
     * Gets two_point_conversion_receptions
     *
     * @return int
     */
    public function getTwoPointConversionReceptions()
    {
        return $this->container['two_point_conversion_receptions'];
    }

    /**
     * Sets two_point_conversion_receptions
     *
     * @param int $two_point_conversion_receptions two_point_conversion_receptions
     *
     * @return $this
     */
    public function setTwoPointConversionReceptions($two_point_conversion_receptions)
    {
        $this->container['two_point_conversion_receptions'] = $two_point_conversion_receptions;

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

