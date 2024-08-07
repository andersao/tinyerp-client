<?php

use Http\Client\Common\Exception\ClientErrorException;
use Http\Client\Common\Exception\ServerErrorException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as HttpClient;
use Prettus\TinyERP\Client;
use Prettus\TinyERP\Exceptions\EmptyResponseException;
use Prettus\TinyERP\Exceptions\UnauthorizedException;
use Prettus\TinyERP\Exceptions\TinyException;
use Psr\Http\Message\ResponseInterface;

it('should throw an error when receiving http error', function ($statusCode, $errorClass) {
    $http = new HttpClient();
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')->andReturn($statusCode);
    $response->shouldReceive('getReasonPhrase')->andReturn('error');
    $http->addResponse($response);

    $client = new Client('token', $http);

    expect(fn () => $client->get('endpoint'))->toThrow($errorClass);
})->with([
    [401, ClientErrorException::class],
    [403, ClientErrorException::class],
    [404, ClientErrorException::class],
    [500, ServerErrorException::class],
    [503, ServerErrorException::class],
]);

it('should throw an error when handling not successful tiny request', function ($responseBody, $errorClass) {
    $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    $http = new HttpClient();
    $response = Mockery::mock(ResponseInterface::class);
    $response->shouldReceive('getStatusCode')->andReturn(200);
    $response->shouldReceive('getBody')->andReturn($streamFactory->createStream($responseBody));
    $http->addResponse($response);

    $client = new Client('token', $http);

    expect(fn () => $client->get('endpoint'))->toThrow($errorClass);
})->with([
    [loadFixture('error/invalid-token.json'), UnauthorizedException::class],
    [loadFixture('error/empty-response.json'), EmptyResponseException::class],
    [loadFixture('error/generic-error.json'), TinyException::class],
]);

// getReasonPhrase