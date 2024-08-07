<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\TagEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class TagResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<TagEntity>
     */
    use SearchOperation;
    use CreateOperation;
    use UpdateOperation;

    /**
     * @use RetrieveOperation<TagEntity>
     */
    use RetrieveOperation;

    public function entityClass(): string
    {
        return TagEntity::class;
    }

    public function createPath(): string
    {
        return '/api2/tag.incluir.php';
    }

    public function updatePath(): string
    {
        return '/api2/tag.alterar.php';
    }

    public function searchPath(): string
    {
        return '/api2/tag.pesquisa.php';
    }

    public function entityKey(): string {
        return 'registro';
    }

    public function entityCollectionKey(): ?string {
        return 'registros';
    }

    public function formParamName(): ?string {
        return 'tag';
    }

    public function formElementCollectionName(): ?string {
        return 'tags';
    }

    public function formElementName(): ?string {
        return 'tag';
    }
}