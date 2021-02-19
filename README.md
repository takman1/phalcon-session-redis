# Redis Adapter for Phalcon/PHP session
There's a deprecation warning when using php-redis extension with Phalcon.

The deprecation come from using setTimeout method instead of expire, in Phalcon Redis backend adapter class.

## Deprecation conditions
- PHP >= 7
- PHP Redis >= 5
- 4 > Phalcon >= 3

## Solution
The solution is to extend Base \Redis class and override setTimeout method.
To do this we extend all Redis adapters chain nad make setTimeout call expire method.

## Deprecated methods
- ```\Redis::setTimeout()```

## Usage
```php
use Takman1\Phalcon\Session\Adapter\Redis;

$session = new Redis(
    [
        "uniqueId"   => "my-private-app",
        "host"       => "localhost",
        "port"       => 6379,
        "auth"       => "foobared",
        "persistent" => false,
        "lifetime"   => 3600,
        "prefix"     => "my",
        "index"      => 1,
    ]
);

$session->start();

$session->set("var", "some-value");

echo $session->get("var");
```
