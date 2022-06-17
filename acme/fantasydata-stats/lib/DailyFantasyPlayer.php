<?php
/**
 * DailyFantasyPlayer
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
 * DailyFantasyPlayer Class Doc Comment
 *
 * @category Class
 * @package     Acme\FantasyDataStats
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class DailyFantasyPlayer implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'DailyFantasyPlayer';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'player_id' => 'int',
        'date' => 'string',
        'short_name' => 'string',
        'name' => 'string',
        'team' => 'string',
        'opponent' => 'string',
        'home_or_away' => 'string',
        'position' => 'string',
        'salary' => 'int',
        'last_game_fantasy_points' => 'float',
        'projected_fantasy_points' => 'float',
        'opponent_rank' => 'int',
        'opponent_position_rank' => 'int',
        'status' => 'string',
        'status_code' => 'string',
        'status_color' => 'string',
        'fan_duel_salary' => 'int',
        'draft_kings_salary' => 'int',
        'yahoo_salary' => 'int',
        'fantasy_data_salary' => 'int',
        'fantasy_draft_salary' => 'int'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'player_id' => null,
        'date' => null,
        'short_name' => null,
        'name' => null,
        'team' => null,
        'opponent' => null,
        'home_or_away' => null,
        'position' => null,
        'salary' => null,
        'last_game_fantasy_points' => null,
        'projected_fantasy_points' => null,
        'opponent_rank' => null,
        'opponent_position_rank' => null,
        'status' => null,
        'status_code' => null,
        'status_color' => null,
        'fan_duel_salary' => null,
        'draft_kings_salary' => null,
        'yahoo_salary' => null,
        'fantasy_data_salary' => null,
        'fantasy_draft_salary' => null
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
        'date' => 'Date',
        'short_name' => 'ShortName',
        'name' => 'Name',
        'team' => 'Team',
        'opponent' => 'Opponent',
        'home_or_away' => 'HomeOrAway',
        'position' => 'Position',
        'salary' => 'Salary',
        'last_game_fantasy_points' => 'LastGameFantasyPoints',
        'projected_fantasy_points' => 'ProjectedFantasyPoints',
        'opponent_rank' => 'OpponentRank',
        'opponent_position_rank' => 'OpponentPositionRank',
        'status' => 'Status',
        'status_code' => 'StatusCode',
        'status_color' => 'StatusColor',
        'fan_duel_salary' => 'FanDuelSalary',
        'draft_kings_salary' => 'DraftKingsSalary',
        'yahoo_salary' => 'YahooSalary',
        'fantasy_data_salary' => 'FantasyDataSalary',
        'fantasy_draft_salary' => 'FantasyDraftSalary'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'player_id' => 'setPlayerId',
        'date' => 'setDate',
        'short_name' => 'setShortName',
        'name' => 'setName',
        'team' => 'setTeam',
        'opponent' => 'setOpponent',
        'home_or_away' => 'setHomeOrAway',
        'position' => 'setPosition',
        'salary' => 'setSalary',
        'last_game_fantasy_points' => 'setLastGameFantasyPoints',
        'projected_fantasy_points' => 'setProjectedFantasyPoints',
        'opponent_rank' => 'setOpponentRank',
        'opponent_position_rank' => 'setOpponentPositionRank',
        'status' => 'setStatus',
        'status_code' => 'setStatusCode',
        'status_color' => 'setStatusColor',
        'fan_duel_salary' => 'setFanDuelSalary',
        'draft_kings_salary' => 'setDraftKingsSalary',
        'yahoo_salary' => 'setYahooSalary',
        'fantasy_data_salary' => 'setFantasyDataSalary',
        'fantasy_draft_salary' => 'setFantasyDraftSalary'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'player_id' => 'getPlayerId',
        'date' => 'getDate',
        'short_name' => 'getShortName',
        'name' => 'getName',
        'team' => 'getTeam',
        'opponent' => 'getOpponent',
        'home_or_away' => 'getHomeOrAway',
        'position' => 'getPosition',
        'salary' => 'getSalary',
        'last_game_fantasy_points' => 'getLastGameFantasyPoints',
        'projected_fantasy_points' => 'getProjectedFantasyPoints',
        'opponent_rank' => 'getOpponentRank',
        'opponent_position_rank' => 'getOpponentPositionRank',
        'status' => 'getStatus',
        'status_code' => 'getStatusCode',
        'status_color' => 'getStatusColor',
        'fan_duel_salary' => 'getFanDuelSalary',
        'draft_kings_salary' => 'getDraftKingsSalary',
        'yahoo_salary' => 'getYahooSalary',
        'fantasy_data_salary' => 'getFantasyDataSalary',
        'fantasy_draft_salary' => 'getFantasyDraftSalary'
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
        $this->container['date'] = isset($data['date']) ? $data['date'] : null;
        $this->container['short_name'] = isset($data['short_name']) ? $data['short_name'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['team'] = isset($data['team']) ? $data['team'] : null;
        $this->container['opponent'] = isset($data['opponent']) ? $data['opponent'] : null;
        $this->container['home_or_away'] = isset($data['home_or_away']) ? $data['home_or_away'] : null;
        $this->container['position'] = isset($data['position']) ? $data['position'] : null;
        $this->container['salary'] = isset($data['salary']) ? $data['salary'] : null;
        $this->container['last_game_fantasy_points'] = isset($data['last_game_fantasy_points']) ? $data['last_game_fantasy_points'] : null;
        $this->container['projected_fantasy_points'] = isset($data['projected_fantasy_points']) ? $data['projected_fantasy_points'] : null;
        $this->container['opponent_rank'] = isset($data['opponent_rank']) ? $data['opponent_rank'] : null;
        $this->container['opponent_position_rank'] = isset($data['opponent_position_rank']) ? $data['opponent_position_rank'] : null;
        $this->container['status'] = isset($data['status']) ? $data['status'] : null;
        $this->container['status_code'] = isset($data['status_code']) ? $data['status_code'] : null;
        $this->container['status_color'] = isset($data['status_color']) ? $data['status_color'] : null;
        $this->container['fan_duel_salary'] = isset($data['fan_duel_salary']) ? $data['fan_duel_salary'] : null;
        $this->container['draft_kings_salary'] = isset($data['draft_kings_salary']) ? $data['draft_kings_salary'] : null;
        $this->container['yahoo_salary'] = isset($data['yahoo_salary']) ? $data['yahoo_salary'] : null;
        $this->container['fantasy_data_salary'] = isset($data['fantasy_data_salary']) ? $data['fantasy_data_salary'] : null;
        $this->container['fantasy_draft_salary'] = isset($data['fantasy_draft_salary']) ? $data['fantasy_draft_salary'] : null;
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
     * Gets opponent
     *
     * @return string
     */
    public function getOpponent()
    {
        return $this->container['opponent'];
    }

    /**
     * Sets opponent
     *
     * @param string $opponent opponent
     *
     * @return $this
     */
    public function setOpponent($opponent)
    {
        $this->container['opponent'] = $opponent;

        return $this;
    }

    /**
     * Gets home_or_away
     *
     * @return string
     */
    public function getHomeOrAway()
    {
        return $this->container['home_or_away'];
    }

    /**
     * Sets home_or_away
     *
     * @param string $home_or_away home_or_away
     *
     * @return $this
     */
    public function setHomeOrAway($home_or_away)
    {
        $this->container['home_or_away'] = $home_or_away;

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
     * Gets salary
     *
     * @return int
     */
    public function getSalary()
    {
        return $this->container['salary'];
    }

    /**
     * Sets salary
     *
     * @param int $salary salary
     *
     * @return $this
     */
    public function setSalary($salary)
    {
        $this->container['salary'] = $salary;

        return $this;
    }

    /**
     * Gets last_game_fantasy_points
     *
     * @return float
     */
    public function getLastGameFantasyPoints()
    {
        return $this->container['last_game_fantasy_points'];
    }

    /**
     * Sets last_game_fantasy_points
     *
     * @param float $last_game_fantasy_points last_game_fantasy_points
     *
     * @return $this
     */
    public function setLastGameFantasyPoints($last_game_fantasy_points)
    {
        $this->container['last_game_fantasy_points'] = $last_game_fantasy_points;

        return $this;
    }

    /**
     * Gets projected_fantasy_points
     *
     * @return float
     */
    public function getProjectedFantasyPoints()
    {
        return $this->container['projected_fantasy_points'];
    }

    /**
     * Sets projected_fantasy_points
     *
     * @param float $projected_fantasy_points projected_fantasy_points
     *
     * @return $this
     */
    public function setProjectedFantasyPoints($projected_fantasy_points)
    {
        $this->container['projected_fantasy_points'] = $projected_fantasy_points;

        return $this;
    }

    /**
     * Gets opponent_rank
     *
     * @return int
     */
    public function getOpponentRank()
    {
        return $this->container['opponent_rank'];
    }

    /**
     * Sets opponent_rank
     *
     * @param int $opponent_rank opponent_rank
     *
     * @return $this
     */
    public function setOpponentRank($opponent_rank)
    {
        $this->container['opponent_rank'] = $opponent_rank;

        return $this;
    }

    /**
     * Gets opponent_position_rank
     *
     * @return int
     */
    public function getOpponentPositionRank()
    {
        return $this->container['opponent_position_rank'];
    }

    /**
     * Sets opponent_position_rank
     *
     * @param int $opponent_position_rank opponent_position_rank
     *
     * @return $this
     */
    public function setOpponentPositionRank($opponent_position_rank)
    {
        $this->container['opponent_position_rank'] = $opponent_position_rank;

        return $this;
    }

    /**
     * Gets status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->container['status'];
    }

    /**
     * Sets status
     *
     * @param string $status status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->container['status'] = $status;

        return $this;
    }

    /**
     * Gets status_code
     *
     * @return string
     */
    public function getStatusCode()
    {
        return $this->container['status_code'];
    }

    /**
     * Sets status_code
     *
     * @param string $status_code status_code
     *
     * @return $this
     */
    public function setStatusCode($status_code)
    {
        $this->container['status_code'] = $status_code;

        return $this;
    }

    /**
     * Gets status_color
     *
     * @return string
     */
    public function getStatusColor()
    {
        return $this->container['status_color'];
    }

    /**
     * Sets status_color
     *
     * @param string $status_color status_color
     *
     * @return $this
     */
    public function setStatusColor($status_color)
    {
        $this->container['status_color'] = $status_color;

        return $this;
    }

    /**
     * Gets fan_duel_salary
     *
     * @return int
     */
    public function getFanDuelSalary()
    {
        return $this->container['fan_duel_salary'];
    }

    /**
     * Sets fan_duel_salary
     *
     * @param int $fan_duel_salary fan_duel_salary
     *
     * @return $this
     */
    public function setFanDuelSalary($fan_duel_salary)
    {
        $this->container['fan_duel_salary'] = $fan_duel_salary;

        return $this;
    }

    /**
     * Gets draft_kings_salary
     *
     * @return int
     */
    public function getDraftKingsSalary()
    {
        return $this->container['draft_kings_salary'];
    }

    /**
     * Sets draft_kings_salary
     *
     * @param int $draft_kings_salary draft_kings_salary
     *
     * @return $this
     */
    public function setDraftKingsSalary($draft_kings_salary)
    {
        $this->container['draft_kings_salary'] = $draft_kings_salary;

        return $this;
    }

    /**
     * Gets yahoo_salary
     *
     * @return int
     */
    public function getYahooSalary()
    {
        return $this->container['yahoo_salary'];
    }

    /**
     * Sets yahoo_salary
     *
     * @param int $yahoo_salary yahoo_salary
     *
     * @return $this
     */
    public function setYahooSalary($yahoo_salary)
    {
        $this->container['yahoo_salary'] = $yahoo_salary;

        return $this;
    }

    /**
     * Gets fantasy_data_salary
     *
     * @return int
     */
    public function getFantasyDataSalary()
    {
        return $this->container['fantasy_data_salary'];
    }

    /**
     * Sets fantasy_data_salary
     *
     * @param int $fantasy_data_salary fantasy_data_salary
     *
     * @return $this
     */
    public function setFantasyDataSalary($fantasy_data_salary)
    {
        $this->container['fantasy_data_salary'] = $fantasy_data_salary;

        return $this;
    }

    /**
     * Gets fantasy_draft_salary
     *
     * @return int
     */
    public function getFantasyDraftSalary()
    {
        return $this->container['fantasy_draft_salary'];
    }

    /**
     * Sets fantasy_draft_salary
     *
     * @param int $fantasy_draft_salary fantasy_draft_salary
     *
     * @return $this
     */
    public function setFantasyDraftSalary($fantasy_draft_salary)
    {
        $this->container['fantasy_draft_salary'] = $fantasy_draft_salary;

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

