<?php
/**
 * DfsSlateGame
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
 * DfsSlateGame Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DfsSlateGame implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'DfsSlateGame';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'slate_game_id' => 'int',
        'slate_id' => 'int',
        'game_id' => 'int',
        'operator_game_id' => 'int',
        'removed_by_operator' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'slate_game_id' => null,
        'slate_id' => null,
        'game_id' => null,
        'operator_game_id' => null,
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
        'slate_game_id' => 'SlateGameID',
        'slate_id' => 'SlateID',
        'game_id' => 'GameID',
        'operator_game_id' => 'OperatorGameID',
        'removed_by_operator' => 'RemovedByOperator'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'slate_game_id' => 'setSlateGameId',
        'slate_id' => 'setSlateId',
        'game_id' => 'setGameId',
        'operator_game_id' => 'setOperatorGameId',
        'removed_by_operator' => 'setRemovedByOperator'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'slate_game_id' => 'getSlateGameId',
        'slate_id' => 'getSlateId',
        'game_id' => 'getGameId',
        'operator_game_id' => 'getOperatorGameId',
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
        $this->container['slate_game_id'] = isset($data['slate_game_id']) ? $data['slate_game_id'] : null;
        $this->container['slate_id'] = isset($data['slate_id']) ? $data['slate_id'] : null;
        $this->container['game_id'] = isset($data['game_id']) ? $data['game_id'] : null;
        $this->container['operator_game_id'] = isset($data['operator_game_id']) ? $data['operator_game_id'] : null;
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
     * Gets game_id
     *
     * @return int
     */
    public function getGameId()
    {
        return $this->container['game_id'];
    }

    /**
     * Sets game_id
     *
     * @param int $game_id game_id
     *
     * @return $this
     */
    public function setGameId($game_id)
    {
        $this->container['game_id'] = $game_id;

        return $this;
    }

    /**
     * Gets operator_game_id
     *
     * @return int
     */
    public function getOperatorGameId()
    {
        return $this->container['operator_game_id'];
    }

    /**
     * Sets operator_game_id
     *
     * @param int $operator_game_id operator_game_id
     *
     * @return $this
     */
    public function setOperatorGameId($operator_game_id)
    {
        $this->container['operator_game_id'] = $operator_game_id;

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

