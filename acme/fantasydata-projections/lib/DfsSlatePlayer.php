<?php
/**
 * DfsSlatePlayer
 *
 * PHP version 5
 *
 * @category Class
 * @package  Acme\FantasyDataProjections
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * NFL v3 Projections
 *
 * NFL projected stats API.
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

namespace Acme\FantasyDataProjections;

use \ArrayAccess;
use \Acme\FantasyDataProjections\ObjectSerializer;

/**
 * DfsSlatePlayer Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataProjections
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DfsSlatePlayer implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'DfsSlatePlayer';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'slate_player_id' => 'int',
        'slate_id' => 'int',
        'slate_game_id' => 'int',
        'player_id' => 'int',
        'player_game_projection_stat_id' => 'int',
        'fantasy_defense_projection_stat_id' => 'int',
        'operator_player_id' => 'string',
        'operator_slate_player_id' => 'string',
        'operator_player_name' => 'string',
        'operator_position' => 'string',
        'operator_roster_slots' => 'string[]',
        'operator_salary' => 'int',
        'team' => 'string',
        'team_id' => 'int',
        'removed_by_operator' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'slate_player_id' => null,
        'slate_id' => null,
        'slate_game_id' => null,
        'player_id' => null,
        'player_game_projection_stat_id' => null,
        'fantasy_defense_projection_stat_id' => null,
        'operator_player_id' => null,
        'operator_slate_player_id' => null,
        'operator_player_name' => null,
        'operator_position' => null,
        'operator_roster_slots' => null,
        'operator_salary' => null,
        'team' => null,
        'team_id' => null,
        'removed_by_operator' => null
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
        'slate_player_id' => 'SlatePlayerID',
        'slate_id' => 'SlateID',
        'slate_game_id' => 'SlateGameID',
        'player_id' => 'PlayerID',
        'player_game_projection_stat_id' => 'PlayerGameProjectionStatID',
        'fantasy_defense_projection_stat_id' => 'FantasyDefenseProjectionStatID',
        'operator_player_id' => 'OperatorPlayerID',
        'operator_slate_player_id' => 'OperatorSlatePlayerID',
        'operator_player_name' => 'OperatorPlayerName',
        'operator_position' => 'OperatorPosition',
        'operator_roster_slots' => 'OperatorRosterSlots',
        'operator_salary' => 'OperatorSalary',
        'team' => 'Team',
        'team_id' => 'TeamID',
        'removed_by_operator' => 'RemovedByOperator'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'slate_player_id' => 'setSlatePlayerId',
        'slate_id' => 'setSlateId',
        'slate_game_id' => 'setSlateGameId',
        'player_id' => 'setPlayerId',
        'player_game_projection_stat_id' => 'setPlayerGameProjectionStatId',
        'fantasy_defense_projection_stat_id' => 'setFantasyDefenseProjectionStatId',
        'operator_player_id' => 'setOperatorPlayerId',
        'operator_slate_player_id' => 'setOperatorSlatePlayerId',
        'operator_player_name' => 'setOperatorPlayerName',
        'operator_position' => 'setOperatorPosition',
        'operator_roster_slots' => 'setOperatorRosterSlots',
        'operator_salary' => 'setOperatorSalary',
        'team' => 'setTeam',
        'team_id' => 'setTeamId',
        'removed_by_operator' => 'setRemovedByOperator'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'slate_player_id' => 'getSlatePlayerId',
        'slate_id' => 'getSlateId',
        'slate_game_id' => 'getSlateGameId',
        'player_id' => 'getPlayerId',
        'player_game_projection_stat_id' => 'getPlayerGameProjectionStatId',
        'fantasy_defense_projection_stat_id' => 'getFantasyDefenseProjectionStatId',
        'operator_player_id' => 'getOperatorPlayerId',
        'operator_slate_player_id' => 'getOperatorSlatePlayerId',
        'operator_player_name' => 'getOperatorPlayerName',
        'operator_position' => 'getOperatorPosition',
        'operator_roster_slots' => 'getOperatorRosterSlots',
        'operator_salary' => 'getOperatorSalary',
        'team' => 'getTeam',
        'team_id' => 'getTeamId',
        'removed_by_operator' => 'getRemovedByOperator'
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
        $this->container['slate_player_id'] = isset($data['slate_player_id']) ? $data['slate_player_id'] : null;
        $this->container['slate_id'] = isset($data['slate_id']) ? $data['slate_id'] : null;
        $this->container['slate_game_id'] = isset($data['slate_game_id']) ? $data['slate_game_id'] : null;
        $this->container['player_id'] = isset($data['player_id']) ? $data['player_id'] : null;
        $this->container['player_game_projection_stat_id'] = isset($data['player_game_projection_stat_id']) ? $data['player_game_projection_stat_id'] : null;
        $this->container['fantasy_defense_projection_stat_id'] = isset($data['fantasy_defense_projection_stat_id']) ? $data['fantasy_defense_projection_stat_id'] : null;
        $this->container['operator_player_id'] = isset($data['operator_player_id']) ? $data['operator_player_id'] : null;
        $this->container['operator_slate_player_id'] = isset($data['operator_slate_player_id']) ? $data['operator_slate_player_id'] : null;
        $this->container['operator_player_name'] = isset($data['operator_player_name']) ? $data['operator_player_name'] : null;
        $this->container['operator_position'] = isset($data['operator_position']) ? $data['operator_position'] : null;
        $this->container['operator_roster_slots'] = isset($data['operator_roster_slots']) ? $data['operator_roster_slots'] : null;
        $this->container['operator_salary'] = isset($data['operator_salary']) ? $data['operator_salary'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['team_id'] = isset($data['team_id']) ? $data['team_id'] : null;
        $this->container['removed_by_operator'] = isset($data['removed_by_operator']) ? $data['removed_by_operator'] : null;
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
     * Gets slate_player_id
     *
     * @return int
     */
    public function getSlatePlayerId()
    {
        return $this->container['slate_player_id'];
    }

    /**
     * Sets slate_player_id
     *
     * @param int $slate_player_id slate_player_id
     *
     * @return $this
     */
    public function setSlatePlayerId($slate_player_id)
    {
        $this->container['slate_player_id'] = $slate_player_id;

        return $this;
    }

    /**
     * Gets slate_id
     *
     * @return int
     */
    public function getSlateId()
    {
        return $this->container['slate_id'];
    }

    /**
     * Sets slate_id
     *
     * @param int $slate_id slate_id
     *
     * @return $this
     */
    public function setSlateId($slate_id)
    {
        $this->container['slate_id'] = $slate_id;

        return $this;
    }

    /**
     * Gets slate_game_id
     *
     * @return int
     */
    public function getSlateGameId()
    {
        return $this->container['slate_game_id'];
    }

    /**
     * Sets slate_game_id
     *
     * @param int $slate_game_id slate_game_id
     *
     * @return $this
     */
    public function setSlateGameId($slate_game_id)
    {
        $this->container['slate_game_id'] = $slate_game_id;

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
     * Gets player_game_projection_stat_id
     *
     * @return int
     */
    public function getPlayerGameProjectionStatId()
    {
        return $this->container['player_game_projection_stat_id'];
    }

    /**
     * Sets player_game_projection_stat_id
     *
     * @param int $player_game_projection_stat_id player_game_projection_stat_id
     *
     * @return $this
     */
    public function setPlayerGameProjectionStatId($player_game_projection_stat_id)
    {
        $this->container['player_game_projection_stat_id'] = $player_game_projection_stat_id;

        return $this;
    }

    /**
     * Gets fantasy_defense_projection_stat_id
     *
     * @return int
     */
    public function getFantasyDefenseProjectionStatId()
    {
        return $this->container['fantasy_defense_projection_stat_id'];
    }

    /**
     * Sets fantasy_defense_projection_stat_id
     *
     * @param int $fantasy_defense_projection_stat_id fantasy_defense_projection_stat_id
     *
     * @return $this
     */
    public function setFantasyDefenseProjectionStatId($fantasy_defense_projection_stat_id)
    {
        $this->container['fantasy_defense_projection_stat_id'] = $fantasy_defense_projection_stat_id;

        return $this;
    }

    /**
     * Gets operator_player_id
     *
     * @return string
     */
    public function getOperatorPlayerId()
    {
        return $this->container['operator_player_id'];
    }

    /**
     * Sets operator_player_id
     *
     * @param string $operator_player_id operator_player_id
     *
     * @return $this
     */
    public function setOperatorPlayerId($operator_player_id)
    {
        $this->container['operator_player_id'] = $operator_player_id;

        return $this;
    }

    /**
     * Gets operator_slate_player_id
     *
     * @return string
     */
    public function getOperatorSlatePlayerId()
    {
        return $this->container['operator_slate_player_id'];
    }

    /**
     * Sets operator_slate_player_id
     *
     * @param string $operator_slate_player_id operator_slate_player_id
     *
     * @return $this
     */
    public function setOperatorSlatePlayerId($operator_slate_player_id)
    {
        $this->container['operator_slate_player_id'] = $operator_slate_player_id;

        return $this;
    }

    /**
     * Gets operator_player_name
     *
     * @return string
     */
    public function getOperatorPlayerName()
    {
        return $this->container['operator_player_name'];
    }

    /**
     * Sets operator_player_name
     *
     * @param string $operator_player_name operator_player_name
     *
     * @return $this
     */
    public function setOperatorPlayerName($operator_player_name)
    {
        $this->container['operator_player_name'] = $operator_player_name;

        return $this;
    }

    /**
     * Gets operator_position
     *
     * @return string
     */
    public function getOperatorPosition()
    {
        return $this->container['operator_position'];
    }

    /**
     * Sets operator_position
     *
     * @param string $operator_position operator_position
     *
     * @return $this
     */
    public function setOperatorPosition($operator_position)
    {
        $this->container['operator_position'] = $operator_position;

        return $this;
    }

    /**
     * Gets operator_roster_slots
     *
     * @return string[]
     */
    public function getOperatorRosterSlots()
    {
        return $this->container['operator_roster_slots'];
    }

    /**
     * Sets operator_roster_slots
     *
     * @param string[] $operator_roster_slots operator_roster_slots
     *
     * @return $this
     */
    public function setOperatorRosterSlots($operator_roster_slots)
    {
        $this->container['operator_roster_slots'] = $operator_roster_slots;

        return $this;
    }

    /**
     * Gets operator_salary
     *
     * @return int
     */
    public function getOperatorSalary()
    {
        return $this->container['operator_salary'];
    }

    /**
     * Sets operator_salary
     *
     * @param int $operator_salary operator_salary
     *
     * @return $this
     */
    public function setOperatorSalary($operator_salary)
    {
        $this->container['operator_salary'] = $operator_salary;

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
     * Gets team_id
     *
     * @return int
     */
    public function getTeamId()
    {
        return $this->container['team_id'];
    }

    /**
     * Sets team_id
     *
     * @param int $team_id team_id
     *
     * @return $this
     */
    public function setTeamId($team_id)
    {
        $this->container['team_id'] = $team_id;

        return $this;
    }

    /**
     * Gets removed_by_operator
     *
     * @return bool
     */
    public function getRemovedByOperator()
    {
        return $this->container['removed_by_operator'];
    }

    /**
     * Sets removed_by_operator
     *
     * @param bool $removed_by_operator removed_by_operator
     *
     * @return $this
     */
    public function setRemovedByOperator($removed_by_operator)
    {
        $this->container['removed_by_operator'] = $removed_by_operator;

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

