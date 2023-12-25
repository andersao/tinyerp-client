# Tiny ERP Client (Beta)

## Installation

```
composer require prettus/tinyerp-client
```

## Usage

```php
use Prettus\TinyERP\Client;

$client = new Client(['token' => 'your-token-here']);
$info = $client->info->retrieve();

print_r($info);
```