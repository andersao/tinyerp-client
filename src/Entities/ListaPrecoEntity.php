<?php

namespace Prettus\TinyERP\Entities;


class ListaPrecoEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly string $descricao;
    public readonly float $acrescimo_desconto;
}