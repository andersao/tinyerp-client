<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\InfoEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Responses\RetornoResponse;
use Psr\Http\Client\ClientExceptionInterface;

class InfoResource extends AbstractResource
{
    use ExtractResponse;

    public function entityClass(): string
    {
        return InfoEntity::class;
    }

    /**
     * @return RetornoResponse<InfoEntity>
     * @throws ClientExceptionInterface
     * @throws \Exception
     */
    public function get(): RetornoResponse
    {
        return $this->extractResponse(
            $this->client->get('https://api.tiny.com.br/api2/info.php')
        );
    }
}