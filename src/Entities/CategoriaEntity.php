<?php

namespace Prettus\TinyERP\Entities;;

class CategoriaEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $descricao;

    /** @var CategoriaEntity[] */
    public readonly ?array $nodes;
}