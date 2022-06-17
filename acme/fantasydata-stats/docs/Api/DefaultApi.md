# Acme\FantasyDataStats\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/stats*

Method | HTTP request | Description
------------- | ------------- | -------------
[**areGamesInProgress**](DefaultApi.md#areGamesInProgress) | **GET** /{format}/AreAnyGamesInProgress | Are Games In Progress
[**boxScoreByScoreidV**](DefaultApi.md#boxScoreByScoreidV) | **GET** /{format}/BoxScoreByScoreIDV3/{scoreid} | Box Score by ScoreID V3
[**boxScoreV**](DefaultApi.md#boxScoreV) | **GET** /{format}/BoxScoreV3/{season}/{week}/{hometeam} | Box Score V3
[**boxScoresDeltaV**](DefaultApi.md#boxScoresDeltaV) | **GET** /{format}/BoxScoresDeltaV3/{season}/{week}/{playerstoinclude}/{minutes} | Box Scores Delta V3
[**boxScoresVSimulation**](DefaultApi.md#boxScoresVSimulation) | **GET** /{format}/SimulatedBoxScoresV3/{numberofplays} | Box Scores V3 Simulation
[**byeWeeks**](DefaultApi.md#byeWeeks) | **GET** /{format}/Byes/{season} | Bye Weeks
[**dailyFantasyPlayers**](DefaultApi.md#dailyFantasyPlayers) | **GET** /{format}/DailyFantasyPlayers/{date} | Daily Fantasy Players
[**dailyFantasyScoring**](DefaultApi.md#dailyFantasyScoring) | **GET** /{format}/DailyFantasyPoints/{date} | Daily Fantasy Scoring
[**dfsSlatesByDate**](DefaultApi.md#dfsSlatesByDate) | **GET** /{format}/DfsSlatesByDate/{date} | DFS Slates by Date
[**dfsSlatesByWeek**](DefaultApi.md#dfsSlatesByWeek) | **GET** /{format}/DfsSlatesByWeek/{season}/{week} | DFS Slates by Week
[**fantasyDefenseGameStats**](DefaultApi.md#fantasyDefenseGameStats) | **GET** /{format}/FantasyDefenseByGame/{season}/{week} | Fantasy Defense Game Stats
[**fantasyDefenseGameStatsByTeam**](DefaultApi.md#fantasyDefenseGameStatsByTeam) | **GET** /{format}/FantasyDefenseByGameByTeam/{season}/{week}/{team} | Fantasy Defense Game Stats by Team
[**fantasyDefenseSeasonStats**](DefaultApi.md#fantasyDefenseSeasonStats) | **GET** /{format}/FantasyDefenseBySeason/{season} | Fantasy Defense Season Stats
[**fantasyDefenseSeasonStatsByTeam**](DefaultApi.md#fantasyDefenseSeasonStatsByTeam) | **GET** /{format}/FantasyDefenseBySeasonByTeam/{season}/{team} | Fantasy Defense Season Stats by Team
[**fantasyPlayerOwnershipPercentagesSeasonLong**](DefaultApi.md#fantasyPlayerOwnershipPercentagesSeasonLong) | **GET** /{format}/PlayerOwnership/{season}/{week} | Fantasy Player Ownership Percentages (Season-Long)
[**fantasyPlayersWithAdp**](DefaultApi.md#fantasyPlayersWithAdp) | **GET** /{format}/FantasyPlayers | Fantasy Players with ADP
[**gameStatsBySeasonDeprecatedUseTeamGameStatsInstead**](DefaultApi.md#gameStatsBySeasonDeprecatedUseTeamGameStatsInstead) | **GET** /{format}/GameStats/{season} | Game Stats by Season (Deprecated, use Team Game Stats instead)
[**gameStatsByWeekDeprecatedUseTeamGameStatsInstead**](DefaultApi.md#gameStatsByWeekDeprecatedUseTeamGameStatsInstead) | **GET** /{format}/GameStatsByWeek/{season}/{week} | Game Stats by Week (Deprecated, use Team Game Stats instead)
[**idpFantasyPlayersWithAdp**](DefaultApi.md#idpFantasyPlayersWithAdp) | **GET** /{format}/FantasyPlayersIDP | IDP Fantasy Players with ADP
[**injuries**](DefaultApi.md#injuries) | **GET** /{format}/Injuries/{season}/{week} | Injuries
[**injuriesByTeam**](DefaultApi.md#injuriesByTeam) | **GET** /{format}/Injuries/{season}/{week}/{team} | Injuries by Team
[**leagueLeadersBySeason**](DefaultApi.md#leagueLeadersBySeason) | **GET** /{format}/SeasonLeagueLeaders/{season}/{position}/{column} | League Leaders by Season
[**leagueLeadersByWeek**](DefaultApi.md#leagueLeadersByWeek) | **GET** /{format}/GameLeagueLeaders/{season}/{week}/{position}/{column} | League Leaders by Week
[**legacyBoxScore**](DefaultApi.md#legacyBoxScore) | **GET** /{format}/BoxScore/{season}/{week}/{hometeam} | Legacy Box Score
[**legacyBoxScores**](DefaultApi.md#legacyBoxScores) | **GET** /{format}/BoxScores/{season}/{week} | Legacy Box Scores
[**legacyBoxScoresActive**](DefaultApi.md#legacyBoxScoresActive) | **GET** /{format}/ActiveBoxScores | Legacy Box Scores Active
[**legacyBoxScoresDelta**](DefaultApi.md#legacyBoxScoresDelta) | **GET** /{format}/BoxScoresDelta/{season}/{week}/{minutes} | Legacy Box Scores Delta
[**legacyBoxScoresDeltaCurrentWeek**](DefaultApi.md#legacyBoxScoresDeltaCurrentWeek) | **GET** /{format}/RecentlyUpdatedBoxScores/{minutes} | Legacy Box Scores Delta (Current Week)
[**legacyBoxScoresFinal**](DefaultApi.md#legacyBoxScoresFinal) | **GET** /{format}/FinalBoxScores | Legacy Box Scores Final
[**legacyBoxScoresLive**](DefaultApi.md#legacyBoxScoresLive) | **GET** /{format}/LiveBoxScores | Legacy Box Scores Live
[**news**](DefaultApi.md#news) | **GET** /{format}/News | News
[**newsByDate**](DefaultApi.md#newsByDate) | **GET** /{format}/NewsByDate/{date} | News by Date
[**newsByPlayer**](DefaultApi.md#newsByPlayer) | **GET** /{format}/NewsByPlayerID/{playerid} | News by Player
[**newsByTeam**](DefaultApi.md#newsByTeam) | **GET** /{format}/NewsByTeam/{team} | News by Team
[**playerDetailsByAvailable**](DefaultApi.md#playerDetailsByAvailable) | **GET** /{format}/Players | Player Details by Available
[**playerDetailsByFreeAgents**](DefaultApi.md#playerDetailsByFreeAgents) | **GET** /{format}/FreeAgents | Player Details by Free Agents
[**playerDetailsByPlayer**](DefaultApi.md#playerDetailsByPlayer) | **GET** /{format}/Player/{playerid} | Player Details by Player
[**playerDetailsByTeam**](DefaultApi.md#playerDetailsByTeam) | **GET** /{format}/Players/{team} | Player Details by Team
[**playerGameRedZoneStats**](DefaultApi.md#playerGameRedZoneStats) | **GET** /{format}/PlayerGameRedZoneStats/{season}/{week} | Player Game Red Zone Stats
[**playerGameStatsByPlayer**](DefaultApi.md#playerGameStatsByPlayer) | **GET** /{format}/PlayerGameStatsByPlayerID/{season}/{week}/{playerid} | Player Game Stats by Player
[**playerGameStatsByTeam**](DefaultApi.md#playerGameStatsByTeam) | **GET** /{format}/PlayerGameStatsByTeam/{season}/{week}/{team} | Player Game Stats by Team
[**playerGameStatsByWeek**](DefaultApi.md#playerGameStatsByWeek) | **GET** /{format}/PlayerGameStatsByWeek/{season}/{week} | Player Game Stats by Week
[**playerGameStatsByWeekDelta**](DefaultApi.md#playerGameStatsByWeekDelta) | **GET** /{format}/PlayerGameStatsByWeekDelta/{season}/{week}/{minutes} | Player Game Stats by Week Delta
[**playerGameStatsDelta**](DefaultApi.md#playerGameStatsDelta) | **GET** /{format}/PlayerGameStatsDelta/{minutes} | Player Game Stats Delta
[**playerSeasonRedZoneStats**](DefaultApi.md#playerSeasonRedZoneStats) | **GET** /{format}/PlayerSeasonRedZoneStats/{season} | Player Season Red Zone Stats
[**playerSeasonStats**](DefaultApi.md#playerSeasonStats) | **GET** /{format}/PlayerSeasonStats/{season} | Player Season Stats
[**playerSeasonStatsByPlayer**](DefaultApi.md#playerSeasonStatsByPlayer) | **GET** /{format}/PlayerSeasonStatsByPlayerID/{season}/{playerid} | Player Season Stats by Player
[**playerSeasonStatsByTeam**](DefaultApi.md#playerSeasonStatsByTeam) | **GET** /{format}/PlayerSeasonStatsByTeam/{season}/{team} | Player Season Stats by Team
[**playerSeasonThirdDownStats**](DefaultApi.md#playerSeasonThirdDownStats) | **GET** /{format}/PlayerSeasonThirdDownStats/{season} | Player Season Third Down Stats
[**proBowlers**](DefaultApi.md#proBowlers) | **GET** /{format}/ProBowlers/{season} | Pro Bowlers
[**schedule**](DefaultApi.md#schedule) | **GET** /{format}/Schedules/{season} | Schedule
[**scoresBySeason**](DefaultApi.md#scoresBySeason) | **GET** /{format}/Scores/{season} | Scores by Season
[**scoresByWeek**](DefaultApi.md#scoresByWeek) | **GET** /{format}/ScoresByWeek/{season}/{week} | Scores by Week
[**scoresByWeekSimulation**](DefaultApi.md#scoresByWeekSimulation) | **GET** /{format}/SimulatedScores/{numberofplays} | Scores by Week Simulation
[**seasonCurrent**](DefaultApi.md#seasonCurrent) | **GET** /{format}/CurrentSeason | Season Current
[**seasonLastCompleted**](DefaultApi.md#seasonLastCompleted) | **GET** /{format}/LastCompletedSeason | Season Last Completed
[**seasonUpcoming**](DefaultApi.md#seasonUpcoming) | **GET** /{format}/UpcomingSeason | Season Upcoming
[**stadiums**](DefaultApi.md#stadiums) | **GET** /{format}/Stadiums | Stadiums
[**standings**](DefaultApi.md#standings) | **GET** /{format}/Standings/{season} | Standings
[**teamGameStats**](DefaultApi.md#teamGameStats) | **GET** /{format}/TeamGameStats/{season}/{week} | Team Game Stats
[**teamSeasonStats**](DefaultApi.md#teamSeasonStats) | **GET** /{format}/TeamSeasonStats/{season} | Team Season Stats
[**teamsActive**](DefaultApi.md#teamsActive) | **GET** /{format}/Teams | Teams (Active)
[**teamsAll**](DefaultApi.md#teamsAll) | **GET** /{format}/AllTeams | Teams (All)
[**teamsBySeason**](DefaultApi.md#teamsBySeason) | **GET** /{format}/Teams/{season} | Teams by Season
[**timeframes**](DefaultApi.md#timeframes) | **GET** /{format}/Timeframes/{type} | Timeframes
[**weekCurrent**](DefaultApi.md#weekCurrent) | **GET** /{format}/CurrentWeek | Week Current
[**weekLastCompleted**](DefaultApi.md#weekLastCompleted) | **GET** /{format}/LastCompletedWeek | Week Last Completed
[**weekUpcoming**](DefaultApi.md#weekUpcoming) | **GET** /{format}/UpcomingWeek | Week Upcoming


# **areGamesInProgress**
> bool areGamesInProgress($format)

Are Games In Progress

Returns <code>true</code> if there is at least one game being played at the time of the request or <code>false</code> if there are none.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->areGamesInProgress($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->areGamesInProgress: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**bool**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **boxScoreByScoreidV**
> \Acme\FantasyDataStats\\BoxScoreV3 boxScoreByScoreidV($format, $scoreid)

Box Score by ScoreID V3

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$scoreid = "scoreid_example"; // string | The ScoreID of the game. Possible values include: <code>16247</code>, <code>16245</code>, etc.

try {
    $result = $apiInstance->boxScoreByScoreidV($format, $scoreid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->boxScoreByScoreidV: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **scoreid** | **string**| The ScoreID of the game. Possible values include: &lt;code&gt;16247&lt;/code&gt;, &lt;code&gt;16245&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\BoxScoreV3**](../Model/BoxScoreV3.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **boxScoreV**
> \Acme\FantasyDataStats\\BoxScoreV3 boxScoreV($format, $season, $week, $hometeam)

Box Score V3

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>
$hometeam = "hometeam_example"; // string | Abbreviation of a team playing in this game. Example: <code>WAS</code>.

try {
    $result = $apiInstance->boxScoreV($format, $season, $week, $hometeam);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->boxScoreV: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |
 **hometeam** | **string**| Abbreviation of a team playing in this game. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScoreV3**](../Model/BoxScoreV3.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **boxScoresDeltaV**
> \Acme\FantasyDataStats\\BoxScoreV3[] boxScoresDeltaV($format, $season, $week, $playerstoinclude, $minutes)

Box Scores Delta V3

This method returns all box scores for a given season and week, but only returns player stats that have changed in the last X minutes. You can also filter by type of player stats to include, such as traditional fantasy players, IDP players or all players.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>
$playerstoinclude = "playerstoinclude_example"; // string | The subcategory of players to include in the returned PlayerGame records. Possible values include:<br><br> <code>all</code> Returns all players<br> <code>fantasy</code> Returns traditional fantasy players (QB, RB, WR, TE, K, DST)<br> <code>idp</code> Returns traditional fantasy players and IDP players.
$minutes = "minutes_example"; // string | Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:<br><code>1</code>,  <code>2</code>, etc.

try {
    $result = $apiInstance->boxScoresDeltaV($format, $season, $week, $playerstoinclude, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->boxScoresDeltaV: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |
 **playerstoinclude** | **string**| The subcategory of players to include in the returned PlayerGame records. Possible values include:&lt;br&gt;&lt;br&gt; &lt;code&gt;all&lt;/code&gt; Returns all players&lt;br&gt; &lt;code&gt;fantasy&lt;/code&gt; Returns traditional fantasy players (QB, RB, WR, TE, K, DST)&lt;br&gt; &lt;code&gt;idp&lt;/code&gt; Returns traditional fantasy players and IDP players. |
 **minutes** | **string**| Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:&lt;br&gt;&lt;code&gt;1&lt;/code&gt;,  &lt;code&gt;2&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\BoxScoreV3[]**](../Model/BoxScoreV3.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **boxScoresVSimulation**
> \Acme\FantasyDataStats\\BoxScoreV3[] boxScoresVSimulation($format, $numberofplays)

Box Scores V3 Simulation

Gets simulated live box scores of NFL games, covering the Conference Championship games on January 21, 2018.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$numberofplays = "numberofplays_example"; // string | The number of plays to progress in this NFL live game simulation. Example entries are <code>0</code>, <code>1</code>, <code>2</code>, <code>3</code>, <code>150</code>, <code>200</code>, etc.

try {
    $result = $apiInstance->boxScoresVSimulation($format, $numberofplays);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->boxScoresVSimulation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **numberofplays** | **string**| The number of plays to progress in this NFL live game simulation. Example entries are &lt;code&gt;0&lt;/code&gt;, &lt;code&gt;1&lt;/code&gt;, &lt;code&gt;2&lt;/code&gt;, &lt;code&gt;3&lt;/code&gt;, &lt;code&gt;150&lt;/code&gt;, &lt;code&gt;200&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\BoxScoreV3[]**](../Model/BoxScoreV3.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **byeWeeks**
> \Acme\FantasyDataStats\\Bye[] byeWeeks($format, $season)

Bye Weeks

Get bye weeks for the teams during a specified NFL season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->byeWeeks($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->byeWeeks: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Bye[]**](../Model/Bye.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dailyFantasyPlayers**
> \Acme\FantasyDataStats\\DailyFantasyPlayer[] dailyFantasyPlayers($format, $date)

Daily Fantasy Players

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the contest for which you're pulling players <code>2014-SEP-21</code>, <code>2014-NOV-15</code>, etc

try {
    $result = $apiInstance->dailyFantasyPlayers($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dailyFantasyPlayers: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the contest for which you&#39;re pulling players &lt;code&gt;2014-SEP-21&lt;/code&gt;, &lt;code&gt;2014-NOV-15&lt;/code&gt;, etc |

### Return type

[**\Acme\FantasyDataStats\\DailyFantasyPlayer[]**](../Model/DailyFantasyPlayer.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dailyFantasyScoring**
> \Acme\FantasyDataStats\\DailyFantasyScoring[] dailyFantasyScoring($format, $date)

Daily Fantasy Scoring

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the contest for which you're pulling players           <code>2014-SEP-21</code>,           <code>2014-NOV-15</code>, etc

try {
    $result = $apiInstance->dailyFantasyScoring($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dailyFantasyScoring: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the contest for which you&#39;re pulling players           &lt;code&gt;2014-SEP-21&lt;/code&gt;,           &lt;code&gt;2014-NOV-15&lt;/code&gt;, etc |

### Return type

[**\Acme\FantasyDataStats\\DailyFantasyScoring[]**](../Model/DailyFantasyScoring.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dfsSlatesByDate**
> \Acme\FantasyDataStats\\DfsSlate[] dfsSlatesByDate($format, $date)

DFS Slates by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the slates. <br>Examples: <code>2017-SEP-25</code>, <code>2017-10-31</code>.

try {
    $result = $apiInstance->dfsSlatesByDate($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dfsSlatesByDate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the slates. &lt;br&gt;Examples: &lt;code&gt;2017-SEP-25&lt;/code&gt;, &lt;code&gt;2017-10-31&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\DfsSlate[]**](../Model/DfsSlate.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dfsSlatesByWeek**
> \Acme\FantasyDataStats\\DfsSlate[] dfsSlatesByWeek($format, $season, $week)

DFS Slates by Week

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>

try {
    $result = $apiInstance->dfsSlatesByWeek($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dfsSlatesByWeek: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\DfsSlate[]**](../Model/DfsSlate.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyDefenseGameStats**
> \Acme\FantasyDataStats\\FantasyDefenseGame[] fantasyDefenseGameStats($format, $season, $week)

Fantasy Defense Game Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->fantasyDefenseGameStats($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyDefenseGameStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\FantasyDefenseGame[]**](../Model/FantasyDefenseGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyDefenseGameStatsByTeam**
> \Acme\FantasyDataStats\\FantasyDefenseGame fantasyDefenseGameStatsByTeam($format, $season, $week, $team)

Fantasy Defense Game Stats by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->fantasyDefenseGameStatsByTeam($format, $season, $week, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyDefenseGameStatsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\FantasyDefenseGame**](../Model/FantasyDefenseGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyDefenseSeasonStats**
> \Acme\FantasyDataStats\\FantasyDefenseSeason[] fantasyDefenseSeasonStats($format, $season)

Fantasy Defense Season Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->fantasyDefenseSeasonStats($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyDefenseSeasonStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\FantasyDefenseSeason[]**](../Model/FantasyDefenseSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyDefenseSeasonStatsByTeam**
> \Acme\FantasyDataStats\\FantasyDefenseSeason fantasyDefenseSeasonStatsByTeam($format, $season, $team)

Fantasy Defense Season Stats by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->fantasyDefenseSeasonStatsByTeam($format, $season, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyDefenseSeasonStatsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\FantasyDefenseSeason**](../Model/FantasyDefenseSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyPlayerOwnershipPercentagesSeasonLong**
> \Acme\FantasyDataStats\\PlayerOwnership[] fantasyPlayerOwnershipPercentagesSeasonLong($format, $season, $week)

Fantasy Player Ownership Percentages (Season-Long)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>

try {
    $result = $apiInstance->fantasyPlayerOwnershipPercentagesSeasonLong($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyPlayerOwnershipPercentagesSeasonLong: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\PlayerOwnership[]**](../Model/PlayerOwnership.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **fantasyPlayersWithAdp**
> \Acme\FantasyDataStats\\FantasyPlayer[] fantasyPlayersWithAdp($format)

Fantasy Players with ADP

This method returns a comprehensive list of draftable fantasy football players, including QB, RB, WR, TE, K and DEF.  Players are sorted by ADP (AverageDraftPosition).

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->fantasyPlayersWithAdp($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->fantasyPlayersWithAdp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\FantasyPlayer[]**](../Model/FantasyPlayer.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **gameStatsBySeasonDeprecatedUseTeamGameStatsInstead**
> \Acme\FantasyDataStats\\Game[] gameStatsBySeasonDeprecatedUseTeamGameStatsInstead($format, $season)

Game Stats by Season (Deprecated, use Team Game Stats instead)

Game stats for a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->gameStatsBySeasonDeprecatedUseTeamGameStatsInstead($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->gameStatsBySeasonDeprecatedUseTeamGameStatsInstead: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Game[]**](../Model/Game.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **gameStatsByWeekDeprecatedUseTeamGameStatsInstead**
> \Acme\FantasyDataStats\\Game[] gameStatsByWeekDeprecatedUseTeamGameStatsInstead($format, $season, $week)

Game Stats by Week (Deprecated, use Team Game Stats instead)

Game stats for a specified season and week.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->gameStatsByWeekDeprecatedUseTeamGameStatsInstead($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->gameStatsByWeekDeprecatedUseTeamGameStatsInstead: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\Game[]**](../Model/Game.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **idpFantasyPlayersWithAdp**
> \Acme\FantasyDataStats\\FantasyPlayer[] idpFantasyPlayersWithAdp($format)

IDP Fantasy Players with ADP

This method returns the top 300+ IDP Fantasy Players for the current or upcoming season, ordered by AverageDraftPositionIDP.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->idpFantasyPlayersWithAdp($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->idpFantasyPlayersWithAdp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\FantasyPlayer[]**](../Model/FantasyPlayer.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **injuries**
> \Acme\FantasyDataStats\\Injury[] injuries($format, $season, $week)

Injuries

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->injuries($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->injuries: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\Injury[]**](../Model/Injury.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **injuriesByTeam**
> \Acme\FantasyDataStats\\Injury[] injuriesByTeam($format, $season, $week, $team)

Injuries by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->injuriesByTeam($format, $season, $week, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->injuriesByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Injury[]**](../Model/Injury.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **leagueLeadersBySeason**
> \Acme\FantasyDataStats\\PlayerSeason[] leagueLeadersBySeason($format, $season, $position, $column)

League Leaders by Season

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$position = "position_example"; // string | Playerâ€™s position that you would like to filter by.
$column = "column_example"; // string | Response member you would like results sorted by.

try {
    $result = $apiInstance->leagueLeadersBySeason($format, $season, $position, $column);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->leagueLeadersBySeason: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **position** | **string**| Playerâ€™s position that you would like to filter by. |
 **column** | **string**| Response member you would like results sorted by. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeason[]**](../Model/PlayerSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **leagueLeadersByWeek**
> \Acme\FantasyDataStats\\PlayerGame[] leagueLeadersByWeek($format, $season, $week, $position, $column)

League Leaders by Week

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$position = "position_example"; // string | Playerâ€™s position that you would like to filter by.
$column = "column_example"; // string | Response member you would like results sorted by.

try {
    $result = $apiInstance->leagueLeadersByWeek($format, $season, $week, $position, $column);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->leagueLeadersByWeek: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **position** | **string**| Playerâ€™s position that you would like to filter by. |
 **column** | **string**| Response member you would like results sorted by. |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame[]**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScore**
> \Acme\FantasyDataStats\\BoxScore legacyBoxScore($format, $season, $week, $hometeam)

Legacy Box Score

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$hometeam = "hometeam_example"; // string | Abbreviation of the home team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->legacyBoxScore($format, $season, $week, $hometeam);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScore: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **hometeam** | **string**| Abbreviation of the home team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScores**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScores($format, $season, $week)

Legacy Box Scores

This method returns all box scores for a given season and week.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->legacyBoxScores($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScores: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScoresActive**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScoresActive($format)

Legacy Box Scores Active

This method returns box scores for all games that are either in-progress or have been updated within the last 30 minutes.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->legacyBoxScoresActive($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScoresActive: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScoresDelta**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScoresDelta($format, $season, $week, $minutes)

Legacy Box Scores Delta

This method returns all box scores for a given season and week, but only returns player stats that have changed in the last X minutes.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>
$minutes = "minutes_example"; // string | Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:<br>           <code>1</code> or <code>2</code>.

try {
    $result = $apiInstance->legacyBoxScoresDelta($format, $season, $week, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScoresDelta: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |
 **minutes** | **string**| Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:&lt;br&gt;           &lt;code&gt;1&lt;/code&gt; or &lt;code&gt;2&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScoresDeltaCurrentWeek**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScoresDeltaCurrentWeek($format, $minutes)

Legacy Box Scores Delta (Current Week)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$minutes = "minutes_example"; // string | Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:<br>           <code>1</code> or <code>2</code>.

try {
    $result = $apiInstance->legacyBoxScoresDeltaCurrentWeek($format, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScoresDeltaCurrentWeek: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **minutes** | **string**| Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:&lt;br&gt;           &lt;code&gt;1&lt;/code&gt; or &lt;code&gt;2&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScoresFinal**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScoresFinal($format)

Legacy Box Scores Final

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->legacyBoxScoresFinal($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScoresFinal: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **legacyBoxScoresLive**
> \Acme\FantasyDataStats\\BoxScore[] legacyBoxScoresLive($format)

Legacy Box Scores Live

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->legacyBoxScoresLive($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->legacyBoxScoresLive: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\BoxScore[]**](../Model/BoxScore.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **news**
> \Acme\FantasyDataStats\\News[] news($format)

News

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->news($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->news: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByDate**
> \Acme\FantasyDataStats\\News[] newsByDate($format, $date)

News by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the news. <br>Examples: <code>2017-JUL-31</code>, <code>2017-SEP-01</code>.

try {
    $result = $apiInstance->newsByDate($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->newsByDate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the news. &lt;br&gt;Examples: &lt;code&gt;2017-JUL-31&lt;/code&gt;, &lt;code&gt;2017-SEP-01&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByPlayer**
> \Acme\FantasyDataStats\\News[] newsByPlayer($format, $playerid)

News by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>14257</code>.

try {
    $result = $apiInstance->newsByPlayer($format, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->newsByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;14257&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByTeam**
> \Acme\FantasyDataStats\\News[] newsByTeam($format, $team)

News by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->newsByTeam($format, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->newsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerDetailsByAvailable**
> \Acme\FantasyDataStats\\Player[] playerDetailsByAvailable($format)

Player Details by Available

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->playerDetailsByAvailable($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerDetailsByAvailable: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Player[]**](../Model/Player.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerDetailsByFreeAgents**
> \Acme\FantasyDataStats\\Player[] playerDetailsByFreeAgents($format)

Player Details by Free Agents

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->playerDetailsByFreeAgents($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerDetailsByFreeAgents: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Player[]**](../Model/Player.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerDetailsByPlayer**
> \Acme\FantasyDataStats\\PlayerDetail playerDetailsByPlayer($format, $playerid)

Player Details by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>732</code>.

try {
    $result = $apiInstance->playerDetailsByPlayer($format, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerDetailsByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;732&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerDetail**](../Model/PlayerDetail.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerDetailsByTeam**
> \Acme\FantasyDataStats\\PlayerDetail[] playerDetailsByTeam($format, $team)

Player Details by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->playerDetailsByTeam($format, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerDetailsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerDetail[]**](../Model/PlayerDetail.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameRedZoneStats**
> \Acme\FantasyDataStats\\PlayerGameRedZone[] playerGameRedZoneStats($format, $season, $week)

Player Game Red Zone Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>

try {
    $result = $apiInstance->playerGameRedZoneStats($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameRedZoneStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\PlayerGameRedZone[]**](../Model/PlayerGameRedZone.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameStatsByPlayer**
> \Acme\FantasyDataStats\\PlayerGame playerGameStatsByPlayer($format, $season, $week, $playerid)

Player Game Stats by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>732</code>.

try {
    $result = $apiInstance->playerGameStatsByPlayer($format, $season, $week, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameStatsByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;732&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameStatsByTeam**
> \Acme\FantasyDataStats\\PlayerGame[] playerGameStatsByTeam($format, $season, $week, $team)

Player Game Stats by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->playerGameStatsByTeam($format, $season, $week, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameStatsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame[]**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameStatsByWeek**
> \Acme\FantasyDataStats\\PlayerGame[] playerGameStatsByWeek($format, $season, $week)

Player Game Stats by Week

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->playerGameStatsByWeek($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameStatsByWeek: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame[]**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameStatsByWeekDelta**
> \Acme\FantasyDataStats\\PlayerGame[] playerGameStatsByWeekDelta($format, $season, $week, $minutes)

Player Game Stats by Week Delta

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$minutes = "minutes_example"; // string | Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:<br>           <code>1</code> or <code>2</code>.

try {
    $result = $apiInstance->playerGameStatsByWeekDelta($format, $season, $week, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameStatsByWeekDelta: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **minutes** | **string**| Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are:&lt;br&gt;           &lt;code&gt;1&lt;/code&gt; or &lt;code&gt;2&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame[]**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerGameStatsDelta**
> \Acme\FantasyDataStats\\PlayerGame[] playerGameStatsDelta($format, $minutes)

Player Game Stats Delta

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$minutes = "minutes_example"; // string | Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are: <code>1</code> or <code>2</code>.

try {
    $result = $apiInstance->playerGameStatsDelta($format, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerGameStatsDelta: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **minutes** | **string**| Only returns player statistics that have changed in the last X minutes.  You specify how many minutes in time to go back.  Valid entries are: &lt;code&gt;1&lt;/code&gt; or &lt;code&gt;2&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerGame[]**](../Model/PlayerGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerSeasonRedZoneStats**
> \Acme\FantasyDataStats\\PlayerSeasonRedZone[] playerSeasonRedZoneStats($format, $season)

Player Season Red Zone Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->playerSeasonRedZoneStats($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerSeasonRedZoneStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeasonRedZone[]**](../Model/PlayerSeasonRedZone.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerSeasonStats**
> \Acme\FantasyDataStats\\PlayerSeason[] playerSeasonStats($format, $season)

Player Season Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->playerSeasonStats($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerSeasonStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeason[]**](../Model/PlayerSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerSeasonStatsByPlayer**
> \Acme\FantasyDataStats\\PlayerSeason playerSeasonStatsByPlayer($format, $season, $playerid)

Player Season Stats by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>732</code>.

try {
    $result = $apiInstance->playerSeasonStatsByPlayer($format, $season, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerSeasonStatsByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;732&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeason**](../Model/PlayerSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerSeasonStatsByTeam**
> \Acme\FantasyDataStats\\PlayerSeason[] playerSeasonStatsByTeam($format, $season, $team)

Player Season Stats by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->playerSeasonStatsByTeam($format, $season, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerSeasonStatsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeason[]**](../Model/PlayerSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playerSeasonThirdDownStats**
> \Acme\FantasyDataStats\\PlayerSeasonThirdDown[] playerSeasonThirdDownStats($format, $season)

Player Season Third Down Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->playerSeasonThirdDownStats($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playerSeasonThirdDownStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\PlayerSeasonThirdDown[]**](../Model/PlayerSeasonThirdDown.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **proBowlers**
> \Acme\FantasyDataStats\\PlayerInfo[] proBowlers($format, $season)

Pro Bowlers

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season <br>Examples: <code>2016</code>, <code>2017</code>

try {
    $result = $apiInstance->proBowlers($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->proBowlers: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season &lt;br&gt;Examples: &lt;code&gt;2016&lt;/code&gt;, &lt;code&gt;2017&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\PlayerInfo[]**](../Model/PlayerInfo.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **schedule**
> \Acme\FantasyDataStats\\Schedule[] schedule($format, $season)

Schedule

Game schedule for a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season (with optional season type).<br>Examples: <code>2018</code>, <code>2018PRE</code>, <code>2018POST</code>, <code>2018STAR</code>, <code>2019</code>, etc.

try {
    $result = $apiInstance->schedule($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->schedule: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season (with optional season type).&lt;br&gt;Examples: &lt;code&gt;2018&lt;/code&gt;, &lt;code&gt;2018PRE&lt;/code&gt;, &lt;code&gt;2018POST&lt;/code&gt;, &lt;code&gt;2018STAR&lt;/code&gt;, &lt;code&gt;2019&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\Schedule[]**](../Model/Schedule.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresBySeason**
> \Acme\FantasyDataStats\\Score[] scoresBySeason($format, $season)

Scores by Season

Game scores for a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season (with optional season type).<br>Examples: <code>2018</code>, <code>2018PRE</code>, <code>2018POST</code>, <code>2018STAR</code>, <code>2019</code>, etc.

try {
    $result = $apiInstance->scoresBySeason($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->scoresBySeason: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season (with optional season type).&lt;br&gt;Examples: &lt;code&gt;2018&lt;/code&gt;, &lt;code&gt;2018PRE&lt;/code&gt;, &lt;code&gt;2018POST&lt;/code&gt;, &lt;code&gt;2018STAR&lt;/code&gt;, &lt;code&gt;2019&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\Score[]**](../Model/Score.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresByWeek**
> \Acme\FantasyDataStats\\Score[] scoresByWeek($format, $season, $week)

Scores by Week

Get game scores for a specified week of a season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->scoresByWeek($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->scoresByWeek: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\Score[]**](../Model/Score.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresByWeekSimulation**
> \Acme\FantasyDataStats\\Score[] scoresByWeekSimulation($format, $numberofplays)

Scores by Week Simulation

Gets simulated live scores of NFL games, covering the Conference Championship games on January 21, 2018.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$numberofplays = "numberofplays_example"; // string | The number of plays to progress in this NFL live game simulation. Example entries are <code>0</code>, <code>1</code>, <code>2</code>, <code>3</code>, <code>150</code>, <code>200</code>, etc.

try {
    $result = $apiInstance->scoresByWeekSimulation($format, $numberofplays);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->scoresByWeekSimulation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **numberofplays** | **string**| The number of plays to progress in this NFL live game simulation. Example entries are &lt;code&gt;0&lt;/code&gt;, &lt;code&gt;1&lt;/code&gt;, &lt;code&gt;2&lt;/code&gt;, &lt;code&gt;3&lt;/code&gt;, &lt;code&gt;150&lt;/code&gt;, &lt;code&gt;200&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataStats\\Score[]**](../Model/Score.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **seasonCurrent**
> int seasonCurrent($format)

Season Current

Year of the current NFL season. This value changes on July 1st. The earliest season for Fantasy data is 2001. The earliest season for Team data is 1985. The earliest season for Fantasy data is 2001. The earliest season for Team data is 1985.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->seasonCurrent($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->seasonCurrent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **seasonLastCompleted**
> int seasonLastCompleted($format)

Season Last Completed

Year of the most recently completed season. this value changes immediately after the Super Bowl. The earliest season for Fantasy data is 2001. The earliest season for Team data is 1985.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->seasonLastCompleted($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->seasonLastCompleted: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **seasonUpcoming**
> int seasonUpcoming($format)

Season Upcoming

Year of the current NFL season, if we are in the mid-season. If we are in the off-season, then year of the next upcoming season. This value changes immediately after the Super Bowl. The earliest season for Fantasy data is 2001. The earliest season for Team data is 1985.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->seasonUpcoming($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->seasonUpcoming: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **stadiums**
> \Acme\FantasyDataStats\\Stadium[] stadiums($format)

Stadiums

This method returns all stadiums.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->stadiums($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->stadiums: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Stadium[]**](../Model/Stadium.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **standings**
> \Acme\FantasyDataStats\\Standing[] standings($format, $season)

Standings

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->standings($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->standings: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Standing[]**](../Model/Standing.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamGameStats**
> \Acme\FantasyDataStats\\TeamGame[] teamGameStats($format, $season, $week)

Team Game Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->teamGameStats($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->teamGameStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataStats\\TeamGame[]**](../Model/TeamGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamSeasonStats**
> \Acme\FantasyDataStats\\TeamSeason[] teamSeasonStats($format, $season)

Team Season Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->teamSeasonStats($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->teamSeasonStats: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\TeamSeason[]**](../Model/TeamSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsActive**
> \Acme\FantasyDataStats\\Team[] teamsActive($format)

Teams (Active)

Gets all active teams.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->teamsActive($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->teamsActive: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsAll**
> \Acme\FantasyDataStats\\Team[] teamsAll($format)

Teams (All)

Gets all teams, including pro bowl teams.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->teamsAll($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->teamsAll: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsBySeason**
> \Acme\FantasyDataStats\\Team[] teamsBySeason($format, $season)

Teams by Season

List of teams playing in a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->teamsBySeason($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->teamsBySeason: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **timeframes**
> \Acme\FantasyDataStats\\Timeframe[] timeframes($format, $type)

Timeframes

Get detailed information about past, present, and future timeframes.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$type = "type_example"; // string | The type of timeframes to return.  Valid entries are <code>current</code> or <code>upcoming</code> or <code>completed</code> or <code>recent</code> or <code>all</code>.

try {
    $result = $apiInstance->timeframes($format, $type);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->timeframes: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **type** | **string**| The type of timeframes to return.  Valid entries are &lt;code&gt;current&lt;/code&gt; or &lt;code&gt;upcoming&lt;/code&gt; or &lt;code&gt;completed&lt;/code&gt; or &lt;code&gt;recent&lt;/code&gt; or &lt;code&gt;all&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataStats\\Timeframe[]**](../Model/Timeframe.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **weekCurrent**
> int weekCurrent($format)

Week Current

Number of the current week of the NFL season. This value usually changes on Tuesday nights or Wednesday mornings at midnight EST. Week number is an integer between 1 and 21 or the word current. Weeks 1 through 17 are regular season weeks. Weeks 18 through 21 are post-season weeks.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->weekCurrent($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->weekCurrent: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **weekLastCompleted**
> int weekLastCompleted($format)

Week Last Completed

Number of the last completed week in the current NFL season. This value changes immediately after the last game of the week is completed and the data is available. This usually happens right after the Monday night game. Week number is an integer between 1 and 21 or the word current. Weeks 1 through 17 are regular season weeks. Weeks 18 through 21 are post-season weeks.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->weekLastCompleted($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->weekLastCompleted: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **weekUpcoming**
> int weekUpcoming($format)

Week Upcoming

Number of the upcoming week of the NFL season. This value changes immediately after the final game of the week is completed. We consider upcoming week to be the current week, until current week is over. Week number is an integer between 1 and 21 or the word current. Weeks 1 through 17 are regular season weeks. Weeks 18 through 21 are post-season weeks.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataStats\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataStats\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->weekUpcoming($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->weekUpcoming: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

**int**

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

