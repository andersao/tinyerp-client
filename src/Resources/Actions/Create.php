<?php

namespace Prettus\TinyERP\Resources\Actions;

use Http\Discovery\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;

trait Create
{
    /**
     * @return string
     */
    protected function createUri(): string
    {
        return sprintf('/%s.incluir.php', static::resourceName());
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function create(array $data): static
    {
        $factory = new Psr17Factory();
        $uri = $this->createUri();

        in_array('sequencia', array_keys($data)) ?: $data['sequencia'] = 1;

        $formData = http_build_query([
            static::entityRootKey() => json_encode([
                static::entityCollectionKey() => [
                    [static::entityRootKey() => $data]
                ]
            ])
        ]);

        $request = $this->requestFactory->createRequest('POST', $uri)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($factory->createStream($formData));

        $response = $this->client->sendRequest($request);
        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['retorno']['status'] === 'OK') {
            $registros = array_map(fn($row) => $row['registro'], $body['retorno']['registros']);
            $record = array_filter($registros, fn($row) => intval($row['sequencia']) === intval($data['sequencia']));

            if (count($record)) {
                $this->values = array_merge($data, $record[0]);
            }
        }

        return $this;
    }
}