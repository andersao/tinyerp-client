<?php

namespace Prettus\TinyERP\Tests;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Exceptions\ConflictException;
use Prettus\TinyERP\Exceptions\EmptyResponseException;
use Prettus\TinyERP\Exceptions\InvalidTokenException;
use Prettus\TinyERP\Exceptions\TooManyRequestsException;
use Prettus\TinyERP\Client;
use Psr\Http\Client\ClientExceptionInterface;

class ClientTest extends TestCase
{
    public function testShouldRequireToken(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Client();
    }

    public function testInitializeClient(): void
    {
        $client = new Client(['token' => '1234567890']);
        $options = $client->getOptions();

        $this->assertInstanceOf(Client::class, $client);
        $this->assertEquals('1234567890', $options['token']);
        $this->assertEquals(Client::API_BASE_URL, $client->getApiBaseUrl());
        $this->assertEquals(Client::API_VERSION, $client->getApiVersion());
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     * @throws EmptyResponseException
     */
    public function testInvalidTokenError(): void
    {
        $this->expectException(InvalidTokenException::class);
        $this->expectExceptionMessage('token invalido');

        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse(
            $this->mockFixtureResponse('api2/error_token_invalido.json')
        );

        $client->info->retrieve();
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     * @throws InvalidTokenException
     */
    public function testEmptyResponseError(): void
    {
        $this->expectException(EmptyResponseException::class);
        $this->expectExceptionMessage('A Consulta não retornou registros');

        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse(
            $this->mockFixtureResponse('api2/error_consulta_vazia.json')
        );

        $client->info->retrieve();
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     * @throws InvalidTokenException
     */
    public function testTooManyRequestsError(): void
    {
        $this->expectException(TooManyRequestsException::class);

        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse(
            $this->mockFixtureResponse('api2/error.json', 429),
        );

        $client->info->retrieve();
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     * @throws ConflictException
     */
    public function testConflictError(): void
    {
        $this->expectException(ConflictException::class);

        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse(
            $this->mockFixtureResponse('api2/error_duplicidade.json',),
        );

        $client->info->retrieve();
    }


    /**
     * @throws Exception
     * @throws InvalidTokenException
     * @throws ClientExceptionInterface
     * @throws EmptyResponseException
     */
    public function testShouldSendRequiredParams(): void
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse($this->mockFixtureResponse('api2/info.json'));
        $client->info->retrieve();

        $request = $httpClient->getLastRequest();
        parse_str($request->getUri()->getQuery(), $query);

        $this->assertEquals('GET', $request->getMethod());
        $this->assertStringEndsWith('info.php', $request->getUri()->getPath());
        $this->assertArrayContains([
            'token' => $client->getToken(),
            'formato' => 'json',
        ], $query);
    }
}