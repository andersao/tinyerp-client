<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\ContatoEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class ContatoResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<ContatoEntity>
     */
    use SearchOperation;

    /**
     * @use RetrieveOperation<ContatoEntity>
     */
    use RetrieveOperation;

    use CreateOperation;
    use UpdateOperation;

    public function entityClass(): string
    {
        return ContatoEntity::class;
    }
}