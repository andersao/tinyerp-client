<?php

namespace Prettus\TinyERP\Resources\Operations;

use Prettus\TinyERP\Client;
use Prettus\TinyERP\Responses\RetornoResponse;

/**
 * @template T
 * @property Client $client
 * @method RetornoResponse extractResponse($response)
 */
trait UpdateOperation
{
    public function updateBatch(): bool
    {
        return true;
    }

    public function updatePath(): string
    {
        return sprintf('/api2/%s.alterar.php', $this->entityKey());
    }

    public function updateFormParamName() : ?string
    {
        return $this->formParamName();
    }

    public function updateFormElementCollectionName() : ?string
    {
        return $this->formElementCollectionName();
    }

    public function updateFormElementName() : ?string
    {
        return $this->formElementName();
    }

    public function updateFormParams(mixed $id, array $data = []) : array
    {
        $batch = $this->updateBatch();
        $paramName = $this->updateFormParamName();
        $collection = $this->updateFormElementCollectionName();
        $element = $this->updateFormElementName();

        if($batch && $collection && $element) {
            $payload = [$paramName => json_encode([$collection=> [[$element=> array_merge(['id'=> $id, 'sequencia'=>1], $data)]]])];
        } else {
            $payload = [$paramName=> json_encode([
                $element=>array_merge(['id'=> $id, 'sequencia'=>1], $data)
            ])];
        }

        return $payload;
    }

    public function update(mixed $id, array $data = []): RetornoResponse
    {
        $payload = $this->updateFormParams($id, $data);
        $endpoint = sprintf('%s/%s', 'https://api.tiny.com.br', $this->updatePath());
        return $this->extractRegistroResponse($this->client->postForm($endpoint, $payload));
    }
}