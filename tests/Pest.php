<?php

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\RequestMatcher\RequestMatcher;
use Http\Mock\Client as HttpClient;
use Prettus\TinyERP\Client;
use Psr\Http\Message\ResponseInterface;
/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

// uses(Tests\TestCase::class)->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function loadFixture(string $filename): string
{
    return file_get_contents(__DIR__ . '/Fixtures/' . $filename);
}


/**
 * @param string $method
 * @param string $uri
 * @param string $responseBody
 * @param int $status
 * @return array{0: Client, 1: HttpClient}
 */
function mockTinyClient(string $method, string $uri, string $responseBody = '', int $status = 200): array
{
    $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    $http = new HttpClient();
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')->andReturn($status);
    $response->shouldReceive('getBody')->andReturn($streamFactory->createStream($responseBody));

    $http->on(new RequestMatcher(
        path: $uri,
        host: 'api.tiny.com.br',
        methods: [$method],
    ), $response);

    return [new Client('token', $http), $http];
}
