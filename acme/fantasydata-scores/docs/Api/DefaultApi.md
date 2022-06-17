# Acme\FantasyDataScores\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/scores*

Method | HTTP request | Description
------------- | ------------- | -------------
[**areGamesInProgress**](DefaultApi.md#areGamesInProgress) | **GET** /{format}/AreAnyGamesInProgress | Are Games In Progress
[**byeWeeks**](DefaultApi.md#byeWeeks) | **GET** /{format}/Byes/{season} | Bye Weeks
[**gameStatsBySeasonDeprecatedUseTeamGameStatsInstead**](DefaultApi.md#gameStatsBySeasonDeprecatedUseTeamGameStatsInstead) | **GET** /{format}/GameStats/{season} | Game Stats by Season (Deprecated, use Team Game Stats instead)
[**gameStatsByWeekDeprecatedUseTeamGameStatsInstead**](DefaultApi.md#gameStatsByWeekDeprecatedUseTeamGameStatsInstead) | **GET** /{format}/GameStatsByWeek/{season}/{week} | Game Stats by Week (Deprecated, use Team Game Stats instead)
[**news**](DefaultApi.md#news) | **GET** /{format}/News | News
[**newsByDate**](DefaultApi.md#newsByDate) | **GET** /{format}/NewsByDate/{date} | News by Date
[**newsByPlayer**](DefaultApi.md#newsByPlayer) | **GET** /{format}/NewsByPlayerID/{playerid} | News by Player
[**newsByTeam**](DefaultApi.md#newsByTeam) | **GET** /{format}/NewsByTeam/{team} | News by Team
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
[**xPing**](DefaultApi.md#xPing) | **GET** /{format}/Ping | X Ping


# **areGamesInProgress**
> bool areGamesInProgress($format)

Are Games In Progress

Returns <code>true</code> if there is at least one game being played at the time of the request or <code>false</code> if there are none.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

# **byeWeeks**
> \Acme\FantasyDataScores\\Bye[] byeWeeks($format, $season)

Bye Weeks

Get bye weeks for the teams during a specified NFL season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Bye[]**](../Model/Bye.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **gameStatsBySeasonDeprecatedUseTeamGameStatsInstead**
> \Acme\FantasyDataScores\\Game[] gameStatsBySeasonDeprecatedUseTeamGameStatsInstead($format, $season)

Game Stats by Season (Deprecated, use Team Game Stats instead)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

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
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataScores\\Game[]**](../Model/Game.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **gameStatsByWeekDeprecatedUseTeamGameStatsInstead**
> \Acme\FantasyDataScores\\Game[] gameStatsByWeekDeprecatedUseTeamGameStatsInstead($format, $season, $week)

Game Stats by Week (Deprecated, use Team Game Stats instead)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Game[]**](../Model/Game.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **news**
> \Acme\FantasyDataScores\\News[] news($format)

News

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByDate**
> \Acme\FantasyDataScores\\News[] newsByDate($format, $date)

News by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByPlayer**
> \Acme\FantasyDataScores\\News[] newsByPlayer($format, $playerid)

News by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **newsByTeam**
> \Acme\FantasyDataScores\\News[] newsByTeam($format, $team)

News by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **schedule**
> \Acme\FantasyDataScores\\Schedule[] schedule($format, $season)

Schedule

Game schedule for a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Schedule[]**](../Model/Schedule.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresBySeason**
> \Acme\FantasyDataScores\\Score[] scoresBySeason($format, $season)

Scores by Season

Game scores for a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Score[]**](../Model/Score.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresByWeek**
> \Acme\FantasyDataScores\\Score[] scoresByWeek($format, $season, $week)

Scores by Week

Get game scores for a specified week of a season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Score[]**](../Model/Score.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **scoresByWeekSimulation**
> \Acme\FantasyDataScores\\Score[] scoresByWeekSimulation($format, $numberofplays)

Scores by Week Simulation

Gets simulated live scores of NFL games, covering the Conference Championship games on January 21, 2018.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Score[]**](../Model/Score.md)

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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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
> \Acme\FantasyDataScores\\Stadium[] stadiums($format)

Stadiums

This method returns all stadiums.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Stadium[]**](../Model/Stadium.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **standings**
> \Acme\FantasyDataScores\\Standing[] standings($format, $season)

Standings

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Standing[]**](../Model/Standing.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamGameStats**
> \Acme\FantasyDataScores\\TeamGame[] teamGameStats($format, $season, $week)

Team Game Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\TeamGame[]**](../Model/TeamGame.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamSeasonStats**
> \Acme\FantasyDataScores\\TeamSeason[] teamSeasonStats($format, $season)

Team Season Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\TeamSeason[]**](../Model/TeamSeason.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsActive**
> \Acme\FantasyDataScores\\Team[] teamsActive($format)

Teams (Active)

Gets all active teams.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsAll**
> \Acme\FantasyDataScores\\Team[] teamsAll($format)

Teams (All)

Gets all teams, including pro bowl teams.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **teamsBySeason**
> \Acme\FantasyDataScores\\Team[] teamsBySeason($format, $season)

Teams by Season

List of teams playing in a specified season.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Team[]**](../Model/Team.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **timeframes**
> \Acme\FantasyDataScores\\Timeframe[] timeframes($format, $type)

Timeframes

Get detailed information about past, present, and future timeframes.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

[**\Acme\FantasyDataScores\\Timeframe[]**](../Model/Timeframe.md)

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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
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

# **xPing**
> xPing($format)

X Ping

Ping NFL API

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataScores\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataScores\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $apiInstance->xPing($format);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->xPing: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

void (empty response body)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

