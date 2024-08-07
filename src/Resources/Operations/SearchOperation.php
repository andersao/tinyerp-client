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
trait SearchOperation
{
    public function searchPath(): string
    {
        return sprintf('/api2/%s.pesquisa.php', $this->entityCollectionKey());
    }

    /**
     * @param array $params
     * @return RetornoResponse<T>
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function search(array $params = []): RetornoResponse
    {
        return $this->extractResponse(
            $this->client->get(sprintf('%s/%s', 'https://api.tiny.com.br', $this->searchPath()), $params)
        );
    }
}