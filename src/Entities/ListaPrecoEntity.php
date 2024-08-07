<?php

namespace Prettus\TinyERP\Entities;


class ListaPrecoEntity extends AbstractEntity
{
    public readonly int|null $id;
    public readonly string $descricao;
    public readonly float|int $acrescimo_desconto;
}