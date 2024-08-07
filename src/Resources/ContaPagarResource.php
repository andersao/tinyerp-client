<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\ContaPagarEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;

class ContaPagarResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<ContaPagarEntity>
     */
    use SearchOperation;

    /**
     * @use RetrieveOperation<ContaPagarEntity>
     */
    use RetrieveOperation;
    use CreateOperation;

    public function entityClass(): string
    {
        return ContaPagarEntity::class;
    }

    public function searchPath(): string
    {
        return '/api2/contas.pagar.pesquisa.php';
    }

    public function createPath(): string
    {
        return '/api2/conta.pagar.incluir.php';
    }

    public function retrievePath(): string
    {
        return '/api2/conta.pagar.obter.php';
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
}