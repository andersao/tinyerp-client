<?php

namespace Prettus\TinyERP\Entities;


class PedidoItem
{
    public readonly ?string $codigo;
    public readonly ?string $descricao;
    public readonly ?string $unidade;
    public readonly ?string $quantidade;
    public readonly ?string $valor_unitario;
}