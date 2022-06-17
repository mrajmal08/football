# Acme\FantasyDataProjections\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/projections*

Method | HTTP request | Description
------------- | ------------- | -------------
[**dfsSlatesByDate**](DefaultApi.md#dfsSlatesByDate) | **GET** /{format}/DfsSlatesByDate/{date} | DFS Slates by Date
[**dfsSlatesByWeek**](DefaultApi.md#dfsSlatesByWeek) | **GET** /{format}/DfsSlatesByWeek/{season}/{week} | DFS Slates by Week
[**projectedFantasyDefenseGameStatsWDfsSalaries**](DefaultApi.md#projectedFantasyDefenseGameStatsWDfsSalaries) | **GET** /{format}/FantasyDefenseProjectionsByGame/{season}/{week} | Projected Fantasy Defense Game Stats (w/ DFS Salaries)
[**projectedFantasyDefenseSeasonStatsWByeWeekAdp**](DefaultApi.md#projectedFantasyDefenseSeasonStatsWByeWeekAdp) | **GET** /{format}/FantasyDefenseProjectionsBySeason/{season} | Projected Fantasy Defense Season Stats (w/ Bye Week, ADP)
[**projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries**](DefaultApi.md#projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries) | **GET** /{format}/PlayerGameProjectionStatsByPlayerID/{season}/{week}/{playerid} | Projected Player Game Stats by Player (w/ Injuries, Lineups, DFS Salaries)
[**projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries**](DefaultApi.md#projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries) | **GET** /{format}/PlayerGameProjectionStatsByTeam/{season}/{week}/{team} | Projected Player Game Stats by Team (w/ Injuries, Lineups, DFS Salaries)
[**projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries**](DefaultApi.md#projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries) | **GET** /{format}/PlayerGameProjectionStatsByWeek/{season}/{week} | Projected Player Game Stats by Week (w/ Injuries, Lineups, DFS Salaries)
[**projectedPlayerSeasonStatsByPlayerWByeWeekAdp**](DefaultApi.md#projectedPlayerSeasonStatsByPlayerWByeWeekAdp) | **GET** /{format}/PlayerSeasonProjectionStatsByPlayerID/{season}/{playerid} | Projected Player Season Stats by Player (w/ Bye Week, ADP)
[**projectedPlayerSeasonStatsByTeamWByeWeekAdp**](DefaultApi.md#projectedPlayerSeasonStatsByTeamWByeWeekAdp) | **GET** /{format}/PlayerSeasonProjectionStatsByTeam/{season}/{team} | Projected Player Season Stats by Team (w/ Bye Week, ADP)
[**projectedPlayerSeasonStatsWByeWeekAdp**](DefaultApi.md#projectedPlayerSeasonStatsWByeWeekAdp) | **GET** /{format}/PlayerSeasonProjectionStats/{season} | Projected Player Season Stats (w/ Bye Week, ADP)


# **dfsSlatesByDate**
> \Acme\FantasyDataProjections\\DfsSlate[] dfsSlatesByDate($format, $date)

DFS Slates by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
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

[**\Acme\FantasyDataProjections\\DfsSlate[]**](../Model/DfsSlate.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dfsSlatesByWeek**
> \Acme\FantasyDataProjections\\DfsSlate[] dfsSlatesByWeek($format, $season, $week)

DFS Slates by Week

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>
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
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt; |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |

### Return type

[**\Acme\FantasyDataProjections\\DfsSlate[]**](../Model/DfsSlate.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedFantasyDefenseGameStatsWDfsSalaries**
> \Acme\FantasyDataProjections\\FantasyDefenseGameProjection[] projectedFantasyDefenseGameStatsWDfsSalaries($format, $season, $week)

Projected Fantasy Defense Game Stats (w/ DFS Salaries)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->projectedFantasyDefenseGameStatsWDfsSalaries($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedFantasyDefenseGameStatsWDfsSalaries: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\FantasyDataProjections\\FantasyDefenseGameProjection[]**](../Model/FantasyDefenseGameProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedFantasyDefenseSeasonStatsWByeWeekAdp**
> \Acme\FantasyDataProjections\\FantasyDefenseSeasonProjection[] projectedFantasyDefenseSeasonStatsWByeWeekAdp($format, $season)

Projected Fantasy Defense Season Stats (w/ Bye Week, ADP)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->projectedFantasyDefenseSeasonStatsWByeWeekAdp($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedFantasyDefenseSeasonStatsWByeWeekAdp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataProjections\\FantasyDefenseSeasonProjection[]**](../Model/FantasyDefenseSeasonProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries**
> \Acme\FantasyDataProjections\\PlayerGameProjection projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries($format, $season, $week, $playerid)

Projected Player Game Stats by Player (w/ Injuries, Lineups, DFS Salaries)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>14257</code>.

try {
    $result = $apiInstance->projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries($format, $season, $week, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerGameStatsByPlayerWInjuriesLineupsDfsSalaries: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: &lt;code&gt;1&lt;/code&gt; |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;14257&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataProjections\\PlayerGameProjection**](../Model/PlayerGameProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries**
> \Acme\FantasyDataProjections\\PlayerGameProjection[] projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries($format, $season, $week, $team)

Projected Player Game Stats by Team (w/ Injuries, Lineups, DFS Salaries)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
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
    $result = $apiInstance->projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries($format, $season, $week, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerGameStatsByTeamWInjuriesLineupsDfsSalaries: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\FantasyDataProjections\\PlayerGameProjection[]**](../Model/PlayerGameProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries**
> \Acme\FantasyDataProjections\\PlayerGameProjection[] projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries($format, $season, $week)

Projected Player Game Stats by Week (w/ Injuries, Lineups, DFS Salaries)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerGameStatsByWeekWInjuriesLineupsDfsSalaries: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\FantasyDataProjections\\PlayerGameProjection[]**](../Model/PlayerGameProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerSeasonStatsByPlayerWByeWeekAdp**
> \Acme\FantasyDataProjections\\PlayerSeasonProjection projectedPlayerSeasonStatsByPlayerWByeWeekAdp($format, $season, $playerid)

Projected Player Season Stats by Player (w/ Bye Week, ADP)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$playerid = "playerid_example"; // string | Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:<code>14257</code>.

try {
    $result = $apiInstance->projectedPlayerSeasonStatsByPlayerWByeWeekAdp($format, $season, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerSeasonStatsByPlayerWByeWeekAdp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **playerid** | **string**| Each NFL player has a unique ID assigned by FantasyData. Player IDs can be determined by pulling player related data. Example:&lt;code&gt;14257&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataProjections\\PlayerSeasonProjection**](../Model/PlayerSeasonProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerSeasonStatsByTeamWByeWeekAdp**
> \Acme\FantasyDataProjections\\PlayerSeasonProjection[] projectedPlayerSeasonStatsByTeamWByeWeekAdp($format, $season, $team)

Projected Player Season Stats by Team (w/ Bye Week, ADP)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->projectedPlayerSeasonStatsByTeamWByeWeekAdp($format, $season, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerSeasonStatsByTeamWByeWeekAdp: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\FantasyDataProjections\\PlayerSeasonProjection[]**](../Model/PlayerSeasonProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **projectedPlayerSeasonStatsWByeWeekAdp**
> \Acme\FantasyDataProjections\\PlayerSeasonProjection[] projectedPlayerSeasonStatsWByeWeekAdp($format, $season)

Projected Player Season Stats (w/ Bye Week, ADP)

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataProjections\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataProjections\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.

try {
    $result = $apiInstance->projectedPlayerSeasonStatsWByeWeekAdp($format, $season);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->projectedPlayerSeasonStatsWByeWeekAdp: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season. &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataProjections\\PlayerSeasonProjection[]**](../Model/PlayerSeasonProjection.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

