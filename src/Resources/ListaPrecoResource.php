<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\ContatoEntity;
use Prettus\TinyERP\Entities\ListaPrecoEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class ListaPrecoResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<ListaPrecoEntity>
     */
    use SearchOperation;

    public function entityClass(): string
    {
        return ListaPrecoEntity::class;
    }

    public function searchPath(): string
    {
        return '/api2/listas.precos.pesquisa.php';
    }

    public function entityKey(): string
    {
        return 'registro';
    }

    public function entityCollectionKey(): ?string
    {
        return 'registros';
    }
}