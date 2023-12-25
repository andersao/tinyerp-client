<?php

namespace Prettus\TinyERP\Tests;

use Http\Discovery\Psr17Factory;
use Http\Mock\Client;
use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Client as TinyClient;
use Psr\Http\Message\ResponseInterface;

define('FIXTURES_PATH', __DIR__ . '/Fixtures/');

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @return list{0:TinyClient, 1: Client, 2: Psr17Factory}
     */
    public function tinyClientSut(): array
    {
        $httpClient = new Client();
        $erpClient = new TinyClient(['token' => '1234567890', 'http_client' => $httpClient]);
        $factory = new Psr17Factory();

        return [$erpClient, $httpClient, $factory];
    }

    /**
     * @param Client $client
     * @param string $filename
     * @param int $statusCode
     * @return Client
     * @throws Exception
     */
    public function setDefaultMockResponse(Client $client, string $filename, int $statusCode = 200): Client
    {
        $client->setDefaultResponse(
            $this->mockFixtureResponse($filename, $statusCode)
        );

        return $client;
    }

    /**
     * @param string $filename
     * @param int $statusCode
     * @return ResponseInterface
     * @throws Exception
     */
    public function mockFixtureResponse(string $filename, int $statusCode = 200): ResponseInterface
    {
        $path = join(DIRECTORY_SEPARATOR, [FIXTURES_PATH, 'response', $filename]);
        $factory = new Psr17Factory();
        $response = $this->createMock('Psr\Http\Message\ResponseInterface');
        $response->method('getStatusCode')->willReturn($statusCode);
        $response->method('getBody')->willReturn(
            $factory->createStream(file_get_contents($path))
        );

        return $response;
    }

    /**
     * @param array $expected
     * @param array $actual
     * @return void
     */
    public function assertArrayContains(array $expected, array $actual): void
    {
        foreach ($expected as $key => $value) {
            if (!array_key_exists($key, $actual)) {
                $this->fail(sprintf('array does not contain the expected key: "%s"', $key));
            }

            if ($actual[$key] !== $value) {
                $this->fail(sprintf('array key "%s" does not match the expected value "%s". actual: "%s"',
                    $key,
                    $value,
                    $actual[$key]
                ));
            }
        }

        $this->assertTrue(true);
    }

    public function assertLastRequest(Client $client, string $expectedMethod, string $expectedPath): void
    {
        $request = $client->getLastRequest();
        $this->assertEquals($expectedMethod, $request->getMethod());
        $this->assertStringEndsWith($expectedPath, $request->getUri()->getPath());
    }

    public function assertAllInstanceOf(string $expectedClass, $actual): void
    {
        $actual = is_array($actual) ? $actual : [$actual];

        foreach ($actual as $item) {
            $this->assertInstanceOf($expectedClass, $item);
        }
    }
}