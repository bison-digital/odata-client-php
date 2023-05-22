## OData Client for PHP

Lightweight library designed to make calling OData REST services in PHP applications easy.

The SDK is designed to around PSR 7 (Message) and 8 (Client) to allow for ultimate flexibility of implimentation.
It is using Guzzles implementation of PSR-7 Request internally but is compatible with any PSR-8 Client.

![Latest Version](https://img.shields.io/packagist/v/bison-digital/odata-client-php)

### Install
```bash
composer require bison-digital/odata-client-php
```

### Example Usage




``` php
use BisonDigital\Odata\DTO\Query;
use BisonDigital\Odata\DTO\Table;
use BisonDigital\Odata\Service\OdataService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Uri;


$oDataService = new OdataService(
  new Client(),
  new Uri('https://services.odata.org/V4/(S(ka3ts5ohyioxa1fcbdcb0jub))/TripPinServiceRW')
);

$query = (new Query())
    ->select('FirstName', 'LastName')
    ->filterString('UserName', 'willieashmore', 'contains')
    ->orderBy('Concurrency')
;

$oDataService->query(new Table('People'), $query);
```

## Issues
Please report any issues using the [issues]('https://github.com/bison-digital/odata-client-php/issues') tab in this repository.

All pull requests and suggestions are welcome.