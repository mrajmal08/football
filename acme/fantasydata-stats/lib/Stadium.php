<?php
/**
 * Stadium
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
 * Stadium Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Stadium implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Stadium';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'stadium_id' => 'int',
        'name' => 'string',
        'city' => 'string',
        'state' => 'string',
        'country' => 'string',
        'capacity' => 'int',
        'playing_surface' => 'string',
        'geo_lat' => 'float',
        'geo_long' => 'float'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'stadium_id' => null,
        'name' => null,
        'city' => null,
        'state' => null,
        'country' => null,
        'capacity' => null,
        'playing_surface' => null,
        'geo_lat' => null,
        'geo_long' => null
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
        'stadium_id' => 'StadiumID',
        'name' => 'Name',
        'city' => 'City',
        'state' => 'State',
        'country' => 'Country',
        'capacity' => 'Capacity',
        'playing_surface' => 'PlayingSurface',
        'geo_lat' => 'GeoLat',
        'geo_long' => 'GeoLong'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'stadium_id' => 'setStadiumId',
        'name' => 'setName',
        'city' => 'setCity',
        'state' => 'setState',
        'country' => 'setCountry',
        'capacity' => 'setCapacity',
        'playing_surface' => 'setPlayingSurface',
        'geo_lat' => 'setGeoLat',
        'geo_long' => 'setGeoLong'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'stadium_id' => 'getStadiumId',
        'name' => 'getName',
        'city' => 'getCity',
        'state' => 'getState',
        'country' => 'getCountry',
        'capacity' => 'getCapacity',
        'playing_surface' => 'getPlayingSurface',
        'geo_lat' => 'getGeoLat',
        'geo_long' => 'getGeoLong'
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
        $this->container['stadium_id'] = isset($data['stadium_id']) ? $data['stadium_id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['city'] = isset($data['city']) ? $data['city'] : null;
        $this->container['state'] = isset($data['state']) ? $data['state'] : null;
        $this->container['country'] = isset($data['country']) ? $data['country'] : null;
        $this->container['capacity'] = isset($data['capacity']) ? $data['capacity'] : null;
        $this->container['playing_surface'] = isset($data['playing_surface']) ? $data['playing_surface'] : null;
        $this->container['geo_lat'] = isset($data['geo_lat']) ? $data['geo_lat'] : null;
        $this->container['geo_long'] = isset($data['geo_long']) ? $data['geo_long'] : null;
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
     * Gets city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->container['city'];
    }

    /**
     * Sets city
     *
     * @param string $city city
     *
     * @return $this
     */
    public function setCity($city)
    {
        $this->container['city'] = $city;

        return $this;
    }

    /**
     * Gets state
     *
     * @return string
     */
    public function getState()
    {
        return $this->container['state'];
    }

    /**
     * Sets state
     *
     * @param string $state state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->container['state'] = $state;

        return $this;
    }

    /**
     * Gets country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->container['country'];
    }

    /**
     * Sets country
     *
     * @param string $country country
     *
     * @return $this
     */
    public function setCountry($country)
    {
        $this->container['country'] = $country;

        return $this;
    }

    /**
     * Gets capacity
     *
     * @return int
     */
    public function getCapacity()
    {
        return $this->container['capacity'];
    }

    /**
     * Sets capacity
     *
     * @param int $capacity capacity
     *
     * @return $this
     */
    public function setCapacity($capacity)
    {
        $this->container['capacity'] = $capacity;

        return $this;
    }

    /**
     * Gets playing_surface
     *
     * @return string
     */
    public function getPlayingSurface()
    {
        return $this->container['playing_surface'];
    }

    /**
     * Sets playing_surface
     *
     * @param string $playing_surface playing_surface
     *
     * @return $this
     */
    public function setPlayingSurface($playing_surface)
    {
        $this->container['playing_surface'] = $playing_surface;

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

