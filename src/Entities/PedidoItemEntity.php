<?php

namespace Prettus\TinyERP\Entities;


class PedidoItemEntity extends AbstractEntity
{
    public readonly ?int $id_produto;
    public readonly ?string $codigo;
    public readonly ?string $descricao;
    public readonly ?string $unidade;
    public readonly ?float $quantidade;
    public readonly ?float $valor_unitario;
}