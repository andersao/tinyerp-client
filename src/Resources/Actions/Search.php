<?php

namespace Prettus\TinyERP\Resources\Actions;

use Psr\Http\Client\ClientExceptionInterface;

trait Search
{
    /**
     * @return string
     */
    protected function searchUri(): string
    {
        return sprintf('%s.pesquisa.php', static::resourceNamePlural());
    }

    /**
     * @return array<static>
     * @throws ClientExceptionInterface
     */
    public function search(array $params = []): array
    {
        $uri = $this->searchUri();

        $query = http_build_query($params);
        $request = $this->requestFactory->createRequest('GET', sprintf('/%s?%s', $uri, $query));
        $content = json_decode($this->client->sendRequest($request)->getBody()->getContents(), true);
        $collection = $content['retorno'][static::entityCollectionKey()];

        $entityRootKey = static::entityRootKey();

        return array_map(function ($value) use ($entityRootKey) {
            $object = clone $this;

            if (!is_null($entityRootKey) && array_key_exists($entityRootKey, $value)) {
                $object->values = $value[$entityRootKey];
            } else {
                $object->values = $value;
            }

            return $object;
        }, $collection);
    }
}