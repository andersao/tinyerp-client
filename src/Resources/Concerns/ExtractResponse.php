<?php

namespace Prettus\TinyERP\Resources\Concerns;

use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @template T
 */
trait ExtractResponse
{
    public function entityClass(): string
    {
        throw new \Exception("Entity class not defined");
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function dataFrom($data): mixed
    {
        $entityClass = $this->entityClass();

        if($entityClass && method_exists($entityClass, 'from')) {
            return $entityClass::from($data);
        }

        return $data;
    }

    /**
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function collectionFrom($data): array
    {
        return array_map(fn($item) => $this->dataFrom($item), $data);
    }

    /**
     * @param ResponseInterface $response
     * @return RetornoResponse<T>
     * @throws \Exception
     */
    public function extractResponse(ResponseInterface $response): RetornoResponse
    {
        $body = json_decode($response->getBody()->getContents(), true);
        $retorno = $body['retorno'] ?? [];
        $output = [
            'status' => $retorno['status'],
            'status_processamento' => intval($retorno['status_processamento']),
        ];

        $rootKey =  $this->entityKey();
        $collectionKey = $this->entityCollectionKey();

        $isSingle = array_key_exists($rootKey, $retorno);
        $isCollection = array_key_exists($collectionKey, $retorno);
        $data = $retorno[$collectionKey]
            ?? $retorno[$rootKey]
            ?? $retorno;

        if($isSingle) {
            $data = $this->dataFrom($data);
        } else if ($isCollection) {
            $data = $this->collectionFrom(array_map(fn($item) => $item[$rootKey] ?? $item, $data));
        }

        $output['data'] = $data;

        if (isset($retorno['pagina'])) {
            $output['pagina'] = $retorno['pagina'];
        }

        if (isset($retorno['numero_paginas'])) {
            $output['numero_paginas'] = $retorno['numero_paginas'];
        }

        return new RetornoResponse(
            status: $output['status'],
            status_processamento: $output['status_processamento'],
            data: $output['data'],
            pagina: $output['pagina'] ?? null,
            numero_paginas: $output['numero_paginas'] ?? null
        );
    }

    /**
     * @param ResponseInterface $response
     * @return RetornoResponse<RegistroResponse>
     * @throws \Exception
     */
    public function extractRegistroResponse(ResponseInterface $response): RetornoResponse
    {
        $body = json_decode($response->getBody()->getContents(), true);
        $retorno = $body['retorno'] ?? [];
        $output = [
            'status' => $retorno['status'],
            'status_processamento' => intval($retorno['status_processamento']),
        ];

        $rootKey =  'registro';
        $collectionKey = 'registros';

        $isCollection = array_key_exists($collectionKey, $retorno);
        $data = $retorno[$collectionKey]
            ?? $retorno[$rootKey]
            ?? [];

        if ($isCollection) {
            $data = array_map(function($item) use ($rootKey) {
                return $item[$rootKey] ?? $item;
            }, array_values($data));
        }

        $output['data'] = array_map(fn($item) => new RegistroResponse(
            sequencia: $item['sequencia'],
            status: $item['status'],
            id: $item['id'] ?? null,
            codigo_erro: $item['codigo_erro'] ?? null,
            erros: $item['erros'] ?? null
        ), $data);

        return new RetornoResponse(
            status: $output['status'],
            status_processamento: $output['status_processamento'],
            data: $output['data']
        );
    }
}