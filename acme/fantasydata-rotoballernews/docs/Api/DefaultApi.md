# Acme\FantasyDataRotoBallerNews\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/news-rotoballer*

Method | HTTP request | Description
------------- | ------------- | -------------
[**premiumNews**](DefaultApi.md#premiumNews) | **GET** /{format}/RotoBallerPremiumNews | Premium News
[**premiumNewsByDate**](DefaultApi.md#premiumNewsByDate) | **GET** /{format}/RotoBallerPremiumNewsByDate/{date} | Premium News by Date
[**premiumNewsByPlayer**](DefaultApi.md#premiumNewsByPlayer) | **GET** /{format}/RotoBallerPremiumNewsByPlayerID/{playerid} | Premium News by Player
[**premiumNewsByTeam**](DefaultApi.md#premiumNewsByTeam) | **GET** /{format}/RotoBallerPremiumNewsByTeam/{team} | Premium News by Team


# **premiumNews**
> \Acme\FantasyDataRotoBallerNews\\News[] premiumNews($format)

Premium News

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerNews\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->premiumNews($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->premiumNews: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerNews\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **premiumNewsByDate**
> \Acme\FantasyDataRotoBallerNews\\News[] premiumNewsByDate($format, $date)

Premium News by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerNews\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the news. <br>Examples: <code>2017-JUL-31</code>, <code>2017-SEP-01</code>.

try {
    $result = $apiInstance->premiumNewsByDate($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->premiumNewsByDate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the news. &lt;br&gt;Examples: &lt;code&gt;2017-JUL-31&lt;/code&gt;, &lt;code&gt;2017-SEP-01&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerNews\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **premiumNewsByPlayer**
> \Acme\FantasyDataRotoBallerNews\\News[] premiumNewsByPlayer($format, $playerid)

Premium News by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerNews\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$playerid = "playerid_example"; // string | Unique FantasyData Player ID. Example:<code>10000507</code>.

try {
    $result = $apiInstance->premiumNewsByPlayer($format, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->premiumNewsByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **playerid** | **string**| Unique FantasyData Player ID. Example:&lt;code&gt;10000507&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerNews\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **premiumNewsByTeam**
> \Acme\FantasyDataRotoBallerNews\\News[] premiumNewsByTeam($format, $team)

Premium News by Team

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerNews\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerNews\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$team = "team_example"; // string | Abbreviation of the team. Example: <code>WAS</code>.

try {
    $result = $apiInstance->premiumNewsByTeam($format, $team);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->premiumNewsByTeam: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **team** | **string**| Abbreviation of the team. Example: &lt;code&gt;WAS&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerNews\\News[]**](../Model/News.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

