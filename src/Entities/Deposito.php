<?php

namespace Prettus\TinyERP\Entities;

use Prettus\TinyERP\Traits\HasMapperBuilder;

class Deposito
{
    use HasMapperBuilder;

    public readonly ?string $nome;
    public readonly ?string $desconsiderar;
    public readonly ?float $saldo;
    public readonly ?string $empresa;
}