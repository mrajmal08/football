# Acme\ProjectionsDFSR\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/projections-dfsr*

Method | HTTP request | Description
------------- | ------------- | -------------
[**dfsrProjectedFantasyDefenseGameStats**](DefaultApi.md#dfsrProjectedFantasyDefenseGameStats) | **GET** /{format}/DfsrFantasyDefenseProjectionsByGame/{season}/{week} | DFSR Projected Fantasy Defense Game Stats
[**dfsrProjectedPlayerGameStats**](DefaultApi.md#dfsrProjectedPlayerGameStats) | **GET** /{format}/DfsrPlayerGameProjectionStatsByWeek/{season}/{week} | DFSR Projected Player Game Stats


# **dfsrProjectedFantasyDefenseGameStats**
> \Acme\ProjectionsDFSR\\FantasyDefenseGameProjectionDfsr[] dfsrProjectedFantasyDefenseGameStats($format, $season, $week)

DFSR Projected Fantasy Defense Game Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\ProjectionsDFSR\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->dfsrProjectedFantasyDefenseGameStats($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dfsrProjectedFantasyDefenseGameStats: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\ProjectionsDFSR\\FantasyDefenseGameProjectionDfsr[]**](../Model/FantasyDefenseGameProjectionDfsr.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **dfsrProjectedPlayerGameStats**
> \Acme\ProjectionsDFSR\\PlayerGameProjectionDfsr[] dfsrProjectedPlayerGameStats($format, $season, $week)

DFSR Projected Player Game Stats

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\ProjectionsDFSR\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\ProjectionsDFSR\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$season = "season_example"; // string | Year of the season and the season type. If no season type is provided, then the default is regular season. <br>Examples: <code>2015REG</code>, <code>2015PRE</code>, <code>2015POST</code>.
$week = "week_example"; // string | Week of the season. Valid values are as follows: Preseason 0 to 4, Regular Season 1 to 17, Postseason 1 to 4. Example: <code>1</code>

try {
    $result = $apiInstance->dfsrProjectedPlayerGameStats($format, $season, $week);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->dfsrProjectedPlayerGameStats: ', $e->getMessage(), PHP_EOL;
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

[**\Acme\ProjectionsDFSR\\PlayerGameProjectionDfsr[]**](../Model/PlayerGameProjectionDfsr.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

