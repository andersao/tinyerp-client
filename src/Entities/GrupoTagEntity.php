<?php

namespace Prettus\TinyERP\Entities;


class GrupoTagEntity extends AbstractEntity
{
    public readonly int|null $id;
    public readonly string $nome;

    public static function entityKey(): string
    {
        return 'grupo_tag';
    }

    public static function entityCollectionKey(): string
    {
        return 'grupos_tag';
    }
}