<?php

namespace Prettus\TinyERP\Entities;

use Prettus\TinyERP\Contracts\Entity;
use Prettus\TinyERP\Contracts\TinyEntity;
use Prettus\TinyERP\Traits\HasMapperBuilder;

abstract class AbstractEntity implements Entity, TinyEntity
{
    use HasMapperBuilder;

    public static function entityKey(): string
    {
        throw new \Exception('method entityKey not implemented');
    }

    public static function entityCollectionKey(): ?string
    {
        return null;
    }
}