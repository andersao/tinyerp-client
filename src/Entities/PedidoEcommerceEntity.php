<?php

namespace Prettus\TinyERP\Entities;


class PedidoEcommerceEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $nome;
    public readonly ?string $numero_pedido;
    public readonly ?string $numero_pedido_canal_venda;

    public static function sourceMapping(): array
    {
        return [
            'numeroPedidoEcommerce'=>'numero_pedido',
            'numeroPedidoCanalVenda'=>'numero_pedido_canal_venda',
            'nomeEcommerce'=>'nome',
        ];
    }
}