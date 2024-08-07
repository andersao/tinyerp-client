<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Client;
use Prettus\TinyERP\Contracts\Resource;

abstract class AbstractResource implements Resource
{
    public function __construct(protected Client $client)
    {

    }

    public function entityKey(): string {
        return $this->entityClass()::entityKey();
    }

    public function entityCollectionKey(): ?string {
        return $this->entityClass()::entityCollectionKey();
    }

    public function formParamName(): ?string {
        return $this->entityKey();
    }

    public function formElementCollectionName(): ?string {
        return $this->entityCollectionKey();
    }

    public function formElementName(): ?string {
        return $this->entityKey();
    }
}