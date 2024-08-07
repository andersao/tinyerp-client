<?php

namespace Prettus\TinyERP\Entities;

class ProdutoAlteradoEntity extends AbstractEntity
{
    public readonly ?string $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $unidade;
    public readonly ?string $preco;
    public readonly ?string $data_alteracao;
}