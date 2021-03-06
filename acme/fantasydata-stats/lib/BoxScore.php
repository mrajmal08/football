<?php
/**
 * BoxScore
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
 * BoxScore Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class BoxScore implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'BoxScore';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'score' => '\Acme\FantasyDataStats\\Score',
        'game' => '\Acme\FantasyDataStats\\Game',
        'scoring_plays' => '\Acme\FantasyDataStats\\ScoringPlay[]',
        'scoring_details' => '\Acme\FantasyDataStats\\ScoringDetail[]',
        'away_fantasy_defense' => '\Acme\FantasyDataStats\\FantasyDefenseGame',
        'home_fantasy_defense' => '\Acme\FantasyDataStats\\FantasyDefenseGame',
        'away_passing' => '\Acme\FantasyDataStats\\PlayerPassing[]',
        'away_rushing' => '\Acme\FantasyDataStats\\PlayerRushing[]',
        'away_receiving' => '\Acme\FantasyDataStats\\PlayerReceiving[]',
        'away_kicking' => '\Acme\FantasyDataStats\\PlayerKicking[]',
        'away_punting' => '\Acme\FantasyDataStats\\PlayerPunting[]',
        'away_kick_punt_returns' => '\Acme\FantasyDataStats\\PlayerKickPuntReturns[]',
        'away_defense' => '\Acme\FantasyDataStats\\PlayerDefense[]',
        'home_passing' => '\Acme\FantasyDataStats\\PlayerPassing[]',
        'home_rushing' => '\Acme\FantasyDataStats\\PlayerRushing[]',
        'home_receiving' => '\Acme\FantasyDataStats\\PlayerReceiving[]',
        'home_kicking' => '\Acme\FantasyDataStats\\PlayerKicking[]',
        'home_punting' => '\Acme\FantasyDataStats\\PlayerPunting[]',
        'home_kick_punt_returns' => '\Acme\FantasyDataStats\\PlayerKickPuntReturns[]',
        'home_defense' => '\Acme\FantasyDataStats\\PlayerDefense[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'score' => null,
        'game' => null,
        'scoring_plays' => null,
        'scoring_details' => null,
        'away_fantasy_defense' => null,
        'home_fantasy_defense' => null,
        'away_passing' => null,
        'away_rushing' => null,
        'away_receiving' => null,
        'away_kicking' => null,
        'away_punting' => null,
        'away_kick_punt_returns' => null,
        'away_defense' => null,
        'home_passing' => null,
        'home_rushing' => null,
        'home_receiving' => null,
        'home_kicking' => null,
        'home_punting' => null,
        'home_kick_punt_returns' => null,
        'home_defense' => null
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
        'score' => 'Score',
        'game' => 'Game',
        'scoring_plays' => 'ScoringPlays',
        'scoring_details' => 'ScoringDetails',
        'away_fantasy_defense' => 'AwayFantasyDefense',
        'home_fantasy_defense' => 'HomeFantasyDefense',
        'away_passing' => 'AwayPassing',
        'away_rushing' => 'AwayRushing',
        'away_receiving' => 'AwayReceiving',
        'away_kicking' => 'AwayKicking',
        'away_punting' => 'AwayPunting',
        'away_kick_punt_returns' => 'AwayKickPuntReturns',
        'away_defense' => 'AwayDefense',
        'home_passing' => 'HomePassing',
        'home_rushing' => 'HomeRushing',
        'home_receiving' => 'HomeReceiving',
        'home_kicking' => 'HomeKicking',
        'home_punting' => 'HomePunting',
        'home_kick_punt_returns' => 'HomeKickPuntReturns',
        'home_defense' => 'HomeDefense'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'score' => 'setScore',
        'game' => 'setGame',
        'scoring_plays' => 'setScoringPlays',
        'scoring_details' => 'setScoringDetails',
        'away_fantasy_defense' => 'setAwayFantasyDefense',
        'home_fantasy_defense' => 'setHomeFantasyDefense',
        'away_passing' => 'setAwayPassing',
        'away_rushing' => 'setAwayRushing',
        'away_receiving' => 'setAwayReceiving',
        'away_kicking' => 'setAwayKicking',
        'away_punting' => 'setAwayPunting',
        'away_kick_punt_returns' => 'setAwayKickPuntReturns',
        'away_defense' => 'setAwayDefense',
        'home_passing' => 'setHomePassing',
        'home_rushing' => 'setHomeRushing',
        'home_receiving' => 'setHomeReceiving',
        'home_kicking' => 'setHomeKicking',
        'home_punting' => 'setHomePunting',
        'home_kick_punt_returns' => 'setHomeKickPuntReturns',
        'home_defense' => 'setHomeDefense'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'score' => 'getScore',
        'game' => 'getGame',
        'scoring_plays' => 'getScoringPlays',
        'scoring_details' => 'getScoringDetails',
        'away_fantasy_defense' => 'getAwayFantasyDefense',
        'home_fantasy_defense' => 'getHomeFantasyDefense',
        'away_passing' => 'getAwayPassing',
        'away_rushing' => 'getAwayRushing',
        'away_receiving' => 'getAwayReceiving',
        'away_kicking' => 'getAwayKicking',
        'away_punting' => 'getAwayPunting',
        'away_kick_punt_returns' => 'getAwayKickPuntReturns',
        'away_defense' => 'getAwayDefense',
        'home_passing' => 'getHomePassing',
        'home_rushing' => 'getHomeRushing',
        'home_receiving' => 'getHomeReceiving',
        'home_kicking' => 'getHomeKicking',
        'home_punting' => 'getHomePunting',
        'home_kick_punt_returns' => 'getHomeKickPuntReturns',
        'home_defense' => 'getHomeDefense'
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
        $this->container['score'] = isset($data['score']) ? $data['score'] : null;
        $this->container['game'] = isset($data['game']) ? $data['game'] : null;
        $this->container['scoring_plays'] = isset($data['scoring_plays']) ? $data['scoring_plays'] : null;
        $this->container['scoring_details'] = isset($data['scoring_details']) ? $data['scoring_details'] : null;
        $this->container['away_fantasy_defense'] = isset($data['away_fantasy_defense']) ? $data['away_fantasy_defense'] : null;
        $this->container['home_fantasy_defense'] = isset($data['home_fantasy_defense']) ? $data['home_fantasy_defense'] : null;
        $this->container['away_passing'] = isset($data['away_passing']) ? $data['away_passing'] : null;
        $this->container['away_rushing'] = isset($data['away_rushing']) ? $data['away_rushing'] : null;
        $this->container['away_receiving'] = isset($data['away_receiving']) ? $data['away_receiving'] : null;
        $this->container['away_kicking'] = isset($data['away_kicking']) ? $data['away_kicking'] : null;
        $this->container['away_punting'] = isset($data['away_punting']) ? $data['away_punting'] : null;
        $this->container['away_kick_punt_returns'] = isset($data['away_kick_punt_returns']) ? $data['away_kick_punt_returns'] : null;
        $this->container['away_defense'] = isset($data['away_defense']) ? $data['away_defense'] : null;
        $this->container['home_passing'] = isset($data['home_passing']) ? $data['home_passing'] : null;
        $this->container['home_rushing'] = isset($data['home_rushing']) ? $data['home_rushing'] : null;
        $this->container['home_receiving'] = isset($data['home_receiving']) ? $data['home_receiving'] : null;
        $this->container['home_kicking'] = isset($data['home_kicking']) ? $data['home_kicking'] : null;
        $this->container['home_punting'] = isset($data['home_punting']) ? $data['home_punting'] : null;
        $this->container['home_kick_punt_returns'] = isset($data['home_kick_punt_returns']) ? $data['home_kick_punt_returns'] : null;
        $this->container['home_defense'] = isset($data['home_defense']) ? $data['home_defense'] : null;
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
     * Gets score
     *
     * @return \Acme\FantasyDataStats\\Score
     */
    public function getScore()
    {
        return $this->container['score'];
    }

    /**
     * Sets score
     *
     * @param \Acme\FantasyDataStats\\Score $score score
     *
     * @return $this
     */
    public function setScore($score)
    {
        $this->container['score'] = $score;

        return $this;
    }

    /**
     * Gets game
     *
     * @return \Acme\FantasyDataStats\\Game
     */
    public function getGame()
    {
        return $this->container['game'];
    }

    /**
     * Sets game
     *
     * @param \Acme\FantasyDataStats\\Game $game game
     *
     * @return $this
     */
    public function setGame($game)
    {
        $this->container['game'] = $game;

        return $this;
    }

    /**
     * Gets scoring_plays
     *
     * @return \Acme\FantasyDataStats\\ScoringPlay[]
     */
    public function getScoringPlays()
    {
        return $this->container['scoring_plays'];
    }

    /**
     * Sets scoring_plays
     *
     * @param \Acme\FantasyDataStats\\ScoringPlay[] $scoring_plays scoring_plays
     *
     * @return $this
     */
    public function setScoringPlays($scoring_plays)
    {
        $this->container['scoring_plays'] = $scoring_plays;

        return $this;
    }

    /**
     * Gets scoring_details
     *
     * @return \Acme\FantasyDataStats\\ScoringDetail[]
     */
    public function getScoringDetails()
    {
        return $this->container['scoring_details'];
    }

    /**
     * Sets scoring_details
     *
     * @param \Acme\FantasyDataStats\\ScoringDetail[] $scoring_details scoring_details
     *
     * @return $this
     */
    public function setScoringDetails($scoring_details)
    {
        $this->container['scoring_details'] = $scoring_details;

        return $this;
    }

    /**
     * Gets away_fantasy_defense
     *
     * @return \Acme\FantasyDataStats\\FantasyDefenseGame
     */
    public function getAwayFantasyDefense()
    {
        return $this->container['away_fantasy_defense'];
    }

    /**
     * Sets away_fantasy_defense
     *
     * @param \Acme\FantasyDataStats\\FantasyDefenseGame $away_fantasy_defense away_fantasy_defense
     *
     * @return $this
     */
    public function setAwayFantasyDefense($away_fantasy_defense)
    {
        $this->container['away_fantasy_defense'] = $away_fantasy_defense;

        return $this;
    }

    /**
     * Gets home_fantasy_defense
     *
     * @return \Acme\FantasyDataStats\\FantasyDefenseGame
     */
    public function getHomeFantasyDefense()
    {
        return $this->container['home_fantasy_defense'];
    }

    /**
     * Sets home_fantasy_defense
     *
     * @param \Acme\FantasyDataStats\\FantasyDefenseGame $home_fantasy_defense home_fantasy_defense
     *
     * @return $this
     */
    public function setHomeFantasyDefense($home_fantasy_defense)
    {
        $this->container['home_fantasy_defense'] = $home_fantasy_defense;

        return $this;
    }

    /**
     * Gets away_passing
     *
     * @return \Acme\FantasyDataStats\\PlayerPassing[]
     */
    public function getAwayPassing()
    {
        return $this->container['away_passing'];
    }

    /**
     * Sets away_passing
     *
     * @param \Acme\FantasyDataStats\\PlayerPassing[] $away_passing away_passing
     *
     * @return $this
     */
    public function setAwayPassing($away_passing)
    {
        $this->container['away_passing'] = $away_passing;

        return $this;
    }

    /**
     * Gets away_rushing
     *
     * @return \Acme\FantasyDataStats\\PlayerRushing[]
     */
    public function getAwayRushing()
    {
        return $this->container['away_rushing'];
    }

    /**
     * Sets away_rushing
     *
     * @param \Acme\FantasyDataStats\\PlayerRushing[] $away_rushing away_rushing
     *
     * @return $this
     */
    public function setAwayRushing($away_rushing)
    {
        $this->container['away_rushing'] = $away_rushing;

        return $this;
    }

    /**
     * Gets away_receiving
     *
     * @return \Acme\FantasyDataStats\\PlayerReceiving[]
     */
    public function getAwayReceiving()
    {
        return $this->container['away_receiving'];
    }

    /**
     * Sets away_receiving
     *
     * @param \Acme\FantasyDataStats\\PlayerReceiving[] $away_receiving away_receiving
     *
     * @return $this
     */
    public function setAwayReceiving($away_receiving)
    {
        $this->container['away_receiving'] = $away_receiving;

        return $this;
    }

    /**
     * Gets away_kicking
     *
     * @return \Acme\FantasyDataStats\\PlayerKicking[]
     */
    public function getAwayKicking()
    {
        return $this->container['away_kicking'];
    }

    /**
     * Sets away_kicking
     *
     * @param \Acme\FantasyDataStats\\PlayerKicking[] $away_kicking away_kicking
     *
     * @return $this
     */
    public function setAwayKicking($away_kicking)
    {
        $this->container['away_kicking'] = $away_kicking;

        return $this;
    }

    /**
     * Gets away_punting
     *
     * @return \Acme\FantasyDataStats\\PlayerPunting[]
     */
    public function getAwayPunting()
    {
        return $this->container['away_punting'];
    }

    /**
     * Sets away_punting
     *
     * @param \Acme\FantasyDataStats\\PlayerPunting[] $away_punting away_punting
     *
     * @return $this
     */
    public function setAwayPunting($away_punting)
    {
        $this->container['away_punting'] = $away_punting;

        return $this;
    }

    /**
     * Gets away_kick_punt_returns
     *
     * @return \Acme\FantasyDataStats\\PlayerKickPuntReturns[]
     */
    public function getAwayKickPuntReturns()
    {
        return $this->container['away_kick_punt_returns'];
    }

    /**
     * Sets away_kick_punt_returns
     *
     * @param \Acme\FantasyDataStats\\PlayerKickPuntReturns[] $away_kick_punt_returns away_kick_punt_returns
     *
     * @return $this
     */
    public function setAwayKickPuntReturns($away_kick_punt_returns)
    {
        $this->container['away_kick_punt_returns'] = $away_kick_punt_returns;

        return $this;
    }

    /**
     * Gets away_defense
     *
     * @return \Acme\FantasyDataStats\\PlayerDefense[]
     */
    public function getAwayDefense()
    {
        return $this->container['away_defense'];
    }

    /**
     * Sets away_defense
     *
     * @param \Acme\FantasyDataStats\\PlayerDefense[] $away_defense away_defense
     *
     * @return $this
     */
    public function setAwayDefense($away_defense)
    {
        $this->container['away_defense'] = $away_defense;

        return $this;
    }

    /**
     * Gets home_passing
     *
     * @return \Acme\FantasyDataStats\\PlayerPassing[]
     */
    public function getHomePassing()
    {
        return $this->container['home_passing'];
    }

    /**
     * Sets home_passing
     *
     * @param \Acme\FantasyDataStats\\PlayerPassing[] $home_passing home_passing
     *
     * @return $this
     */
    public function setHomePassing($home_passing)
    {
        $this->container['home_passing'] = $home_passing;

        return $this;
    }

    /**
     * Gets home_rushing
     *
     * @return \Acme\FantasyDataStats\\PlayerRushing[]
     */
    public function getHomeRushing()
    {
        return $this->container['home_rushing'];
    }

    /**
     * Sets home_rushing
     *
     * @param \Acme\FantasyDataStats\\PlayerRushing[] $home_rushing home_rushing
     *
     * @return $this
     */
    public function setHomeRushing($home_rushing)
    {
        $this->container['home_rushing'] = $home_rushing;

        return $this;
    }

    /**
     * Gets home_receiving
     *
     * @return \Acme\FantasyDataStats\\PlayerReceiving[]
     */
    public function getHomeReceiving()
    {
        return $this->container['home_receiving'];
    }

    /**
     * Sets home_receiving
     *
     * @param \Acme\FantasyDataStats\\PlayerReceiving[] $home_receiving home_receiving
     *
     * @return $this
     */
    public function setHomeReceiving($home_receiving)
    {
        $this->container['home_receiving'] = $home_receiving;

        return $this;
    }

    /**
     * Gets home_kicking
     *
     * @return \Acme\FantasyDataStats\\PlayerKicking[]
     */
    public function getHomeKicking()
    {
        return $this->container['home_kicking'];
    }

    /**
     * Sets home_kicking
     *
     * @param \Acme\FantasyDataStats\\PlayerKicking[] $home_kicking home_kicking
     *
     * @return $this
     */
    public function setHomeKicking($home_kicking)
    {
        $this->container['home_kicking'] = $home_kicking;

        return $this;
    }

    /**
     * Gets home_punting
     *
     * @return \Acme\FantasyDataStats\\PlayerPunting[]
     */
    public function getHomePunting()
    {
        return $this->container['home_punting'];
    }

    /**
     * Sets home_punting
     *
     * @param \Acme\FantasyDataStats\\PlayerPunting[] $home_punting home_punting
     *
     * @return $this
     */
    public function setHomePunting($home_punting)
    {
        $this->container['home_punting'] = $home_punting;

        return $this;
    }

    /**
     * Gets home_kick_punt_returns
     *
     * @return \Acme\FantasyDataStats\\PlayerKickPuntReturns[]
     */
    public function getHomeKickPuntReturns()
    {
        return $this->container['home_kick_punt_returns'];
    }

    /**
     * Sets home_kick_punt_returns
     *
     * @param \Acme\FantasyDataStats\\PlayerKickPuntReturns[] $home_kick_punt_returns home_kick_punt_returns
     *
     * @return $this
     */
    public function setHomeKickPuntReturns($home_kick_punt_returns)
    {
        $this->container['home_kick_punt_returns'] = $home_kick_punt_returns;

        return $this;
    }

    /**
     * Gets home_defense
     *
     * @return \Acme\FantasyDataStats\\PlayerDefense[]
     */
    public function getHomeDefense()
    {
        return $this->container['home_defense'];
    }

    /**
     * Sets home_defense
     *
     * @param \Acme\FantasyDataStats\\PlayerDefense[] $home_defense home_defense
     *
     * @return $this
     */
    public function setHomeDefense($home_defense)
    {
        $this->container['home_defense'] = $home_defense;

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

