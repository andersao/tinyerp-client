<?php

namespace Prettus\TinyERP\Entities;

class ProdutoAlteradoEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $unidade;
    public readonly ?float $preco;
    public readonly ?string $data_alteracao;
}