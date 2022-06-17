# Acme\FantasyDataRotoBallerArticles\DefaultApi

All URIs are relative to *http://api.fantasydata.net/v3/nfl/articles-rotoballer*

Method | HTTP request | Description
------------- | ------------- | -------------
[**rotoballerArticles**](DefaultApi.md#rotoballerArticles) | **GET** /{format}/RotoBallerArticles | RotoBaller Articles
[**rotoballerArticlesByDate**](DefaultApi.md#rotoballerArticlesByDate) | **GET** /{format}/RotoBallerArticlesByDate/{date} | RotoBaller Articles by Date
[**rotoballerArticlesByPlayer**](DefaultApi.md#rotoballerArticlesByPlayer) | **GET** /{format}/RotoBallerArticlesByPlayerID/{playerid} | RotoBaller Articles by Player


# **rotoballerArticles**
> \Acme\FantasyDataRotoBallerArticles\\Article[] rotoballerArticles($format)

RotoBaller Articles

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerArticles\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.

try {
    $result = $apiInstance->rotoballerArticles($format);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->rotoballerArticles: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerArticles\\Article[]**](../Model/Article.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **rotoballerArticlesByDate**
> \Acme\FantasyDataRotoBallerArticles\\Article[] rotoballerArticlesByDate($format, $date)

RotoBaller Articles by Date

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerArticles\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$date = "date_example"; // string | The date of the news. <br>Examples: <code>2017-JUL-31</code>, <code>2017-SEP-01</code>.

try {
    $result = $apiInstance->rotoballerArticlesByDate($format, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->rotoballerArticlesByDate: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **date** | **string**| The date of the news. &lt;br&gt;Examples: &lt;code&gt;2017-JUL-31&lt;/code&gt;, &lt;code&gt;2017-SEP-01&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerArticles\\Article[]**](../Model/Article.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **rotoballerArticlesByPlayer**
> \Acme\FantasyDataRotoBallerArticles\\Article[] rotoballerArticlesByPlayer($format, $playerid)

RotoBaller Articles by Player

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure API key authorization: apiKeyHeader
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('Ocp-Apim-Subscription-Key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('Ocp-Apim-Subscription-Key', 'Bearer');
// Configure API key authorization: apiKeyQuery
$config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKey('subscription-key', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Acme\FantasyDataRotoBallerArticles\Configuration::getDefaultConfiguration()->setApiKeyPrefix('subscription-key', 'Bearer');

$apiInstance = new Acme\FantasyDataRotoBallerArticles\Api\DefaultApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$format = "format_example"; // string | Desired response format. Valid entries are <code>XML</code> or <code>JSON</code>.
$playerid = "playerid_example"; // string | Unique FantasyData Player ID. Example:<code>10000507</code>.

try {
    $result = $apiInstance->rotoballerArticlesByPlayer($format, $playerid);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling DefaultApi->rotoballerArticlesByPlayer: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **format** | **string**| Desired response format. Valid entries are &lt;code&gt;XML&lt;/code&gt; or &lt;code&gt;JSON&lt;/code&gt;. |
 **playerid** | **string**| Unique FantasyData Player ID. Example:&lt;code&gt;10000507&lt;/code&gt;. |

### Return type

[**\Acme\FantasyDataRotoBallerArticles\\Article[]**](../Model/Article.md)

### Authorization

[apiKeyHeader](../../README.md#apiKeyHeader), [apiKeyQuery](../../README.md#apiKeyQuery)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

