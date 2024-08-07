<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\ContaReceberEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class ContaReceberResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<ContaReceberEntity>
     */
    use SearchOperation;

    /**
     * @use RetrieveOperation<ContaReceberEntity>
     */
    use RetrieveOperation;
    use CreateOperation;
    use UpdateOperation;

    public function entityClass(): string
    {
        return ContaReceberEntity::class;
    }

    public function searchPath(): string
    {
        return '/api2/contas.receber.pesquisa.php';
    }

    public function createPath(): string
    {
        return '/api2/conta.receber.incluir.php';
    }

    public function updatePath(): string
    {
        return '/api2/conta.receber.alterar.php';
    }

    public function retrievePath(): string
    {
        return '/api2/conta.receber.obter.php';
    }

    public function entityKey(): string
    {
        return 'conta';
    }

    public function entityCollectionKey(): ?string
    {
        return 'contas';
    }

    public function createBath(): bool
    {
        return false;
    }

    public function updateBatch(): bool
    {
        return false;
    }
}