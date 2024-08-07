<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\GrupoTagEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class GrupoTagResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<GrupoTagEntity>
     */
    use SearchOperation;
    use CreateOperation;
    use UpdateOperation;

    public function entityClass(): string
    {
        return GrupoTagEntity::class;
    }

    public function searchPath(): string
    {
        return 'api2/grupo.tag.pesquisa.php';
    }

    public function createPath(): string
    {
        return 'api2/grupo.tag.incluir.php';
    }

    public function updatePath(): string
    {
        return 'api2/grupo.tag.alterar.php';
    }

    public function entityKey(): string {
        return 'registro';
    }

    public function entityCollectionKey(): ?string {
        return 'registros';
    }

    public function formParamName(): ?string {
        return 'grupo';
    }

    public function formElementCollectionName(): ?string {
        return 'grupos_tag';
    }

    public function formElementName(): ?string {
        return 'grupo_tag';
    }
}