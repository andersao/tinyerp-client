<?php

namespace Prettus\TinyERP\Entities;

class ProdutoVariacaoEntity extends AbstractEntity
{
    public readonly ?string $id;
    public readonly ?string $codigo;
    public readonly ?string $preco;
    public readonly ?string $grade;
}