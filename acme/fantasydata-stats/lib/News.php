<?php
/**
 * News
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
 * News Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class News implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'News';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'news_id' => 'int',
        'source' => 'string',
        'updated' => 'string',
        'time_ago' => 'string',
        'title' => 'string',
        'content' => 'string',
        'url' => 'string',
        'terms_of_use' => 'string',
        'author' => 'string',
        'categories' => 'string',
        'player_id' => 'int',
        'team_id' => 'int',
        'team' => 'string',
        'player_id2' => 'int',
        'team_id2' => 'int',
        'team2' => 'string'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'news_id' => null,
        'source' => null,
        'updated' => null,
        'time_ago' => null,
        'title' => null,
        'content' => null,
        'url' => null,
        'terms_of_use' => null,
        'author' => null,
        'categories' => null,
        'player_id' => null,
        'team_id' => null,
        'team' => null,
        'player_id2' => null,
        'team_id2' => null,
        'team2' => null
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
        'news_id' => 'NewsID',
        'source' => 'Source',
        'updated' => 'Updated',
        'time_ago' => 'TimeAgo',
        'title' => 'Title',
        'content' => 'Content',
        'url' => 'Url',
        'terms_of_use' => 'TermsOfUse',
        'author' => 'Author',
        'categories' => 'Categories',
        'player_id' => 'PlayerID',
        'team_id' => 'TeamID',
        'team' => 'Team',
        'player_id2' => 'PlayerID2',
        'team_id2' => 'TeamID2',
        'team2' => 'Team2'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'news_id' => 'setNewsId',
        'source' => 'setSource',
        'updated' => 'setUpdated',
        'time_ago' => 'setTimeAgo',
        'title' => 'setTitle',
        'content' => 'setContent',
        'url' => 'setUrl',
        'terms_of_use' => 'setTermsOfUse',
        'author' => 'setAuthor',
        'categories' => 'setCategories',
        'player_id' => 'setPlayerId',
        'team_id' => 'setTeamId',
        'team' => 'setTeam',
        'player_id2' => 'setPlayerId2',
        'team_id2' => 'setTeamId2',
        'team2' => 'setTeam2'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'news_id' => 'getNewsId',
        'source' => 'getSource',
        'updated' => 'getUpdated',
        'time_ago' => 'getTimeAgo',
        'title' => 'getTitle',
        'content' => 'getContent',
        'url' => 'getUrl',
        'terms_of_use' => 'getTermsOfUse',
        'author' => 'getAuthor',
        'categories' => 'getCategories',
        'player_id' => 'getPlayerId',
        'team_id' => 'getTeamId',
        'team' => 'getTeam',
        'player_id2' => 'getPlayerId2',
        'team_id2' => 'getTeamId2',
        'team2' => 'getTeam2'
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
        $this->container['news_id'] = isset($data['news_id']) ? $data['news_id'] : null;
        $this->container['source'] = isset($data['source']) ? $data['source'] : null;
        $this->container['updated'] = isset($data['updated']) ? $data['updated'] : null;
        $this->container['time_ago'] = isset($data['time_ago']) ? $data['time_ago'] : null;
        $this->container['title'] = isset($data['title']) ? $data['title'] : null;
        $this->container['content'] = isset($data['content']) ? $data['content'] : null;
        $this->container['url'] = isset($data['url']) ? $data['url'] : null;
        $this->container['terms_of_use'] = isset($data['terms_of_use']) ? $data['terms_of_use'] : null;
        $this->container['author'] = isset($data['author']) ? $data['author'] : null;
        $this->container['categories'] = isset($data['categories']) ? $data['categories'] : null;
        $this->container['player_id'] = isset($data['player_id']) ? $data['player_id'] : null;
        $this->container['team_id'] = isset($data['team_id']) ? $data['team_id'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['player_id2'] = isset($data['player_id2']) ? $data['player_id2'] : null;
        $this->container['team_id2'] = isset($data['team_id2']) ? $data['team_id2'] : null;
        $this->container['team2'] = isset($data['team2']) ? $data['team2'] : null;
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
     * Gets news_id
     *
     * @return int
     */
    public function getNewsId()
    {
        return $this->container['news_id'];
    }

    /**
     * Sets news_id
     *
     * @param int $news_id news_id
     *
     * @return $this
     */
    public function setNewsId($news_id)
    {
        $this->container['news_id'] = $news_id;

        return $this;
    }

    /**
     * Gets source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->container['source'];
    }

    /**
     * Sets source
     *
     * @param string $source source
     *
     * @return $this
     */
    public function setSource($source)
    {
        $this->container['source'] = $source;

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
     * Gets time_ago
     *
     * @return string
     */
    public function getTimeAgo()
    {
        return $this->container['time_ago'];
    }

    /**
     * Sets time_ago
     *
     * @param string $time_ago time_ago
     *
     * @return $this
     */
    public function setTimeAgo($time_ago)
    {
        $this->container['time_ago'] = $time_ago;

        return $this;
    }

    /**
     * Gets title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->container['title'];
    }

    /**
     * Sets title
     *
     * @param string $title title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->container['title'] = $title;

        return $this;
    }

    /**
     * Gets content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->container['content'];
    }

    /**
     * Sets content
     *
     * @param string $content content
     *
     * @return $this
     */
    public function setContent($content)
    {
        $this->container['content'] = $content;

        return $this;
    }

    /**
     * Gets url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->container['url'];
    }

    /**
     * Sets url
     *
     * @param string $url url
     *
     * @return $this
     */
    public function setUrl($url)
    {
        $this->container['url'] = $url;

        return $this;
    }

    /**
     * Gets terms_of_use
     *
     * @return string
     */
    public function getTermsOfUse()
    {
        return $this->container['terms_of_use'];
    }

    /**
     * Sets terms_of_use
     *
     * @param string $terms_of_use terms_of_use
     *
     * @return $this
     */
    public function setTermsOfUse($terms_of_use)
    {
        $this->container['terms_of_use'] = $terms_of_use;

        return $this;
    }

    /**
     * Gets author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->container['author'];
    }

    /**
     * Sets author
     *
     * @param string $author author
     *
     * @return $this
     */
    public function setAuthor($author)
    {
        $this->container['author'] = $author;

        return $this;
    }

    /**
     * Gets categories
     *
     * @return string
     */
    public function getCategories()
    {
        return $this->container['categories'];
    }

    /**
     * Sets categories
     *
     * @param string $categories categories
     *
     * @return $this
     */
    public function setCategories($categories)
    {
        $this->container['categories'] = $categories;

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
     * Gets player_id2
     *
     * @return int
     */
    public function getPlayerId2()
    {
        return $this->container['player_id2'];
    }

    /**
     * Sets player_id2
     *
     * @param int $player_id2 player_id2
     *
     * @return $this
     */
    public function setPlayerId2($player_id2)
    {
        $this->container['player_id2'] = $player_id2;

        return $this;
    }

    /**
     * Gets team_id2
     *
     * @return int
     */
    public function getTeamId2()
    {
        return $this->container['team_id2'];
    }

    /**
     * Sets team_id2
     *
     * @param int $team_id2 team_id2
     *
     * @return $this
     */
    public function setTeamId2($team_id2)
    {
        $this->container['team_id2'] = $team_id2;

        return $this;
    }

    /**
     * Gets team2
     *
     * @return string
     */
    public function getTeam2()
    {
        return $this->container['team2'];
    }

    /**
     * Sets team2
     *
     * @param string $team2 team2
     *
     * @return $this
     */
    public function setTeam2($team2)
    {
        $this->container['team2'] = $team2;

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
