# Acme\FantasyDataPlayByPlay\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/pbp*

Method | HTTP request | Description
------------- | ------------- | -------------
[**playByPlay**](DefaultApi.md#playByPlay) | **GET** /{format}/PlayByPlay/{season}/{week}/{hometeam} | Play By Play
[**playByPlayDelta**](DefaultApi.md#playByPlayDelta) | **GET** /{format}/PlayByPlayDelta/{season}/{week}/{minutes} | Play By Play Delta
[**playByPlaySimulation**](DefaultApi.md#playByPlaySimulation) | **GET** /{format}/SimulatedPlayByPlay/{numberofplays} | Play By Play Simulation


# **playByPlay**
> \Acme\FantasyDataPlayByPlay\\PlayByPlay playByPlay($format, $season, $week, $hometeam)

Play By Play

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataPlayByPlay\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season.           <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: <code>1</code>
$hometeam = "hometeam_example"; // string | Abbreviation of the home team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->playByPlay($format, $season, $week, $hometeam);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playByPlay: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **season** | **string**| Year of the season and the season type. If no season type is provided, then the default is regular season.           &lt;br&gt;Examples: &lt;code&gt;2015REG&lt;/code&gt;, &lt;code&gt;2015PRE&lt;/code&gt;, &lt;code&gt;2015POST&lt;/code&gt;. |
 **week** | **string**| Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4.           Example: &lt;code&gt;1&lt;/code&gt; |
 **hometeam** | **string**| Abbreviation of the home team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataPlayByPlay\\PlayByPlay**](../Model/PlayByPlay.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playByPlayDelta**
> \Acme\FantasyDataPlayByPlay\\PlayByPlay[] playByPlayDelta($format, $season, $week, $minutes)

Play By Play Delta

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataPlayByPlay\Api\DefaultApi(
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
    $result = $apiInstance->playByPlayDelta($format, $season, $week, $minutes);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playByPlayDelta: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\FantasyDataPlayByPlay\\PlayByPlay[]**](../Model/PlayByPlay.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **playByPlaySimulation**
> \Acme\FantasyDataPlayByPlay\\PlayByPlay[] playByPlaySimulation($format, $numberofplays)

Play By Play Simulation

Gets simulated live play-by-play of NFL games, covering the Conference Championship games on January 21, 2018.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataPlayByPlay\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataPlayByPlay\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$numberofplays = "numberofplays_example"; // string | The number of plays to progress in this NFL live game simulation. Example entries are <code>0</code>, <code>1</code>, <code>2</code>, <code>3</code>, <code>150</code>, <code>200</code>, etc.

try {
    $result = $apiInstance->playByPlaySimulation($format, $numberofplays);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->playByPlaySimulation: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **numberofplays** | **string**| The number of plays to progress in this NFL live game simulation. Example entries are &lt;code&gt;0&lt;/code&gt;, &lt;code&gt;1&lt;/code&gt;, &lt;code&gt;2&lt;/code&gt;, &lt;code&gt;3&lt;/code&gt;, &lt;code&gt;150&lt;/code&gt;, &lt;code&gt;200&lt;/code&gt;, etc. |

### Return type

[**\Acme\FantasyDataPlayByPlay\\PlayByPlay[]**](../Model/PlayByPlay.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

