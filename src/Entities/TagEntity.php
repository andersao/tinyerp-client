<?php

namespace Prettus\TinyERP\Entities;


class TagEntity extends AbstractEntity
{
    public readonly int|null $id;
    public readonly string $nome;
    public readonly ?string $id_grupo;
    public readonly ?string $grupo;

    public static function entityKey(): string
    {
        return 'tag';
    }

    public static function entityCollectionKey(): string
    {
        return 'tags';
    }

    public static function sourceMapping(): array
    {
        return [
            'id_tag'=>'id',
            'nome_tag'=>'nome',
            'valor'=>'total_pedido',
        ];
    }
}