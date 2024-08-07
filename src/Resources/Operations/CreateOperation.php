<?php

namespace Prettus\TinyERP\Resources\Operations;

use Prettus\TinyERP\Client;
use Prettus\TinyERP\Responses\RetornoResponse;

/**
 * @template T
 * @property Client $client
 * @method RetornoResponse extractResponse($response)
 * @method string entityKey()
 * @method ?string entityCollectionKey()
 */
trait CreateOperation
{
    public function createBath(): bool
    {
        return true;
    }

    public function createPath(): string
    {
        return sprintf('/api2/%s.incluir.php', $this->entityKey());
    }

    public function createFormParamName() : ?string
    {
        return $this->formParamName();
    }

    public function createFormElementCollectionName() : ?string
    {
        return $this->formElementCollectionName();
    }

    public function createFormElementName() : ?string
    {
        return $this->formElementName();
    }
 
    public function create(array $data = []): RetornoResponse
    {
        $batch = $this->createBath();
        $paramName = $this->createFormParamName();
        $collection = $this->createFormElementCollectionName();
        $element = $this->createFormElementName();

        if($batch) {
            $params = json_encode([$collection => [[$element => array_merge($data, ['sequencia' => 1])]]]);
        } else {
            $params = json_encode([$element => $data]);
        }

        $payload = [$paramName=>$params];

        $endpoint = sprintf('%s/%s', 'https://api.tiny.com.br', $this->createPath());
        return $this->extractRegistroResponse(
            $this->client->postForm($endpoint,$payload)
        );
    }
}