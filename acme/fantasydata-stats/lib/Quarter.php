<?php
/**
 * Quarter
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
 * Quarter Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class Quarter implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'Quarter';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'quarter_id' => 'int',
        'score_id' => 'int',
        'number' => 'int',
        'name' => 'string',
        'description' => 'string',
        'away_team_score' => 'int',
        'home_team_score' => 'int',
        'updated' => 'string',
        'created' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'quarter_id' => null,
        'score_id' => null,
        'number' => null,
        'name' => null,
        'description' => null,
        'away_team_score' => null,
        'home_team_score' => null,
        'updated' => null,
        'created' => null
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
        'quarter_id' => 'QuarterID',
        'score_id' => 'ScoreID',
        'number' => 'Number',
        'name' => 'Name',
        'description' => 'Description',
        'away_team_score' => 'AwayTeamScore',
        'home_team_score' => 'HomeTeamScore',
        'updated' => 'Updated',
        'created' => 'Created'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'quarter_id' => 'setQuarterId',
        'score_id' => 'setScoreId',
        'number' => 'setNumber',
        'name' => 'setName',
        'description' => 'setDescription',
        'away_team_score' => 'setAwayTeamScore',
        'home_team_score' => 'setHomeTeamScore',
        'updated' => 'setUpdated',
        'created' => 'setCreated'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'quarter_id' => 'getQuarterId',
        'score_id' => 'getScoreId',
        'number' => 'getNumber',
        'name' => 'getName',
        'description' => 'getDescription',
        'away_team_score' => 'getAwayTeamScore',
        'home_team_score' => 'getHomeTeamScore',
        'updated' => 'getUpdated',
        'created' => 'getCreated'
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
        $this->container['quarter_id'] = isset($data['quarter_id']) ? $data['quarter_id'] : null;
        $this->container['score_id'] = isset($data['score_id']) ? $data['score_id'] : null;
        $this->container['number'] = isset($data['number']) ? $data['number'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['description'] = isset($data['description']) ? $data['description'] : null;
        $this->container['away_team_score'] = isset($data['away_team_score']) ? $data['away_team_score'] : null;
        $this->container['home_team_score'] = isset($data['home_team_score']) ? $data['home_team_score'] : null;
        $this->container['updated'] = isset($data['updated']) ? $data['updated'] : null;
        $this->container['created'] = isset($data['created']) ? $data['created'] : null;
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
     * Gets quarter_id
     *
     * @return int
     */
    public function getQuarterId()
    {
        return $this->container['quarter_id'];
    }

    /**
     * Sets quarter_id
     *
     * @param int $quarter_id quarter_id
     *
     * @return $this
     */
    public function setQuarterId($quarter_id)
    {
        $this->container['quarter_id'] = $quarter_id;

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
     * Gets description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->container['description'];
    }

    /**
     * Sets description
     *
     * @param string $description description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->container['description'] = $description;

        return $this;
    }

    /**
     * Gets away_team_score
     *
     * @return int
     */
    public function getAwayTeamScore()
    {
        return $this->container['away_team_score'];
    }

    /**
     * Sets away_team_score
     *
     * @param int $away_team_score away_team_score
     *
     * @return $this
     */
    public function setAwayTeamScore($away_team_score)
    {
        $this->container['away_team_score'] = $away_team_score;

        return $this;
    }

    /**
     * Gets home_team_score
     *
     * @return int
     */
    public function getHomeTeamScore()
    {
        return $this->container['home_team_score'];
    }

    /**
     * Sets home_team_score
     *
     * @param int $home_team_score home_team_score
     *
     * @return $this
     */
    public function setHomeTeamScore($home_team_score)
    {
        $this->container['home_team_score'] = $home_team_score;

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
     * Gets created
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->container['created'];
    }

    /**
     * Sets created
     *
     * @param string $created created
     *
     * @return $this
     */
    public function setCreated($created)
    {
        $this->container['created'] = $created;

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

