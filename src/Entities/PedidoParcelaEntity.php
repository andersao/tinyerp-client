<?php

namespace Prettus\TinyERP\Entities;


class PedidoParcelaEntity extends AbstractEntity
{
    public readonly ?string $dias;
    public readonly ?string $data;
    public readonly ?float $valor;
    public readonly ?string $obs;
    public readonly ?string $forma_pagamento;
    public readonly ?string $meio_pagamento;
}