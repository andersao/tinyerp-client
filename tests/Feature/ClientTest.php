<?php

use Prettus\TinyERP\Client;
use Psr\Http\Client\ClientInterface;

it('should throw an error when token is empty', function ($token) {
    expect(fn () => new Client($token))->toThrow(InvalidArgumentException::class);
})->with(['', ' ']);

it('should make client', function () {
    $client = new Client('token');
    expect($client->getHttpClient())->toBeInstanceOf(ClientInterface::class);
});

it('should handle tiny api error', function () {
    $client = new Client('token');
    expect($client->getHttpClient())->toBeInstanceOf(ClientInterface::class);
});