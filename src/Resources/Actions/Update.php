<?php

namespace Prettus\TinyERP\Resources\Actions;

use Http\Discovery\Psr17Factory;
use Psr\Http\Client\ClientExceptionInterface;

trait Update
{
    /**
     * @return string
     */
    protected function updateUri(): string
    {
        return sprintf('/%s.alterar.php', static::resourceName());
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function update(int|string $id, array $data): static
    {
        $factory = new Psr17Factory();
        $uri = $this->updateUri();

        in_array('sequencia', array_keys($data)) ?: $data['sequencia'] = 1;

        $formData = http_build_query([
            static::entityRootKey() => json_encode([
                static::entityCollectionKey() => [
                    [static::entityRootKey() => array_merge($data, ['id' => $id])]
                ]
            ])
        ]);

        $request = $this->requestFactory->createRequest('POST', $uri)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($factory->createStream($formData));

        $response = $this->client->sendRequest($request);
        $body = json_decode($response->getBody()->getContents(), true);

        if ($body['retorno']['status'] === 'OK') {
            $registros = array_map(fn($row) => $row['registro'], $body['retorno']['registros'] ?? []);
            $record = array_filter($registros, fn($row) => intval($row['sequencia']) === intval($data['sequencia']));

            if (count($record)) {
                $this->values = array_merge($data, $record[0]);
            }
        }

        return $this;
    }
}