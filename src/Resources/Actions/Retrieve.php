<?php

namespace Prettus\TinyERP\Resources\Actions;

use Psr\Http\Client\ClientExceptionInterface;

trait Retrieve
{
    /**
     * @return string
     */
    protected function retrieveUri(): string
    {
        return sprintf('%s.obter.php', static::resourceName());
    }

    /**
     * @param int|string $id
     * @return $this
     * @throws ClientExceptionInterface
     */
    public function retrieve(int|string $id): static
    {
        $params = ['id' => $id];
        $uri = $this->retrieveUri();
        $query = http_build_query($params);

        $request = $this->requestFactory->createRequest('GET', sprintf('/%s?%s', $uri, $query));
        $response = $this->client->sendRequest($request);

        $content = json_decode($response->getBody()->getContents(), true);

        $this->values = $content['retorno'][static::entityRootKey()];

        return $this;
    }
}