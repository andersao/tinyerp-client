<?php

namespace Prettus\TinyERP\Entities;

class DepositoEntity extends AbstractEntity
{
    public readonly ?string $nome;
    public readonly ?string $desconsiderar;
    public readonly ?float $saldo;
    public readonly ?string $empresa;
}