<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\VendedorEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\SearchOperation;

class VendedorResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<VendedorEntity>
     */
    use SearchOperation;

    public function entityClass(): string
    {
        return VendedorEntity::class;
    }

    public function entityKey(): string
    {
        return 'vendedor';
    }

    public function entityCollectionKey(): ?string
    {
        return 'vendedores';
    }
}