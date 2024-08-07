<?php

namespace Prettus\TinyERP\Resources\Operations;

use Prettus\TinyERP\Client;
use Prettus\TinyERP\Responses\RetornoResponse;
use Psr\Http\Client\ClientExceptionInterface;

/**
 * @template T
 * @property Client $client
 * @method RetornoResponse extractResponse($response)
 */
trait RetrieveOperation
{
    public function retrievePath(): string
    {
        return sprintf('api2/%s.obter.php', $this->entityKey());
    }

    /**
     * @param mixed $id
     * @param array $params
     * @return RetornoResponse<T>
     * @throws ClientExceptionInterface
     */
    public function retrieve(mixed $id, array $params = []): RetornoResponse
    {
        $endpoint = sprintf('%s/%s', 'https://api.tiny.com.br', $this->retrievePath());
        return $this->extractResponse(
            $this->client->get($endpoint, array_merge(['id' => $id], $params))
        );
    }
}