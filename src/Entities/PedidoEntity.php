<?php

namespace Prettus\TinyERP\Entities;


class PedidoEntity extends AbstractEntity
{
    public readonly ?string $id;
    public readonly ?string $nome;
    public readonly ?string $numero;
    public readonly ?string $numero_ecommerce;
    public readonly ?string $data_pedido;
    public readonly ?string $data_prevista;
    public readonly ?string $data_faturamento;
    public readonly ?string $condicao_pagamento;
    public readonly ?string $forma_pagamento;
    public readonly ?string $meio_pagamento;
    public readonly ?string $nome_transportador;
    public readonly ?string $frete_por_conta;
    public readonly ?string $valor_frete;
    public readonly ?string $valor_desconto;
    public readonly ?string $total_produtos;
    public readonly ?string $total_pedido;
    public readonly ?string $numero_ordem_compra;
    public readonly ?string $deposito;
    public readonly ?string $forma_envio;
    public readonly ?string $forma_frete;
    public readonly ?string $situacao;
    public readonly ?string $obs;
    public readonly ?string $id_vendedor;
    public readonly ?string $nome_vendedor;
    public readonly ?string $codigo_rastreamento;
    public readonly ?string $url_rastreamento;
    public readonly ?string $id_nota_fiscal;
    public readonly ?PedidoCliente $cliente;

    /**
     * @var PedidoMarcador[]|null
     */
    public readonly ?array $marcadores;

    /**
     * @var PedidoParcela[]|null
     */
    public readonly ?array $parcelas;

    /**
     * @var PedidoItem[]|null
     */
    public readonly ?array $itens;

    public static function entityKey(): string
    {
        return 'pedido';
    }

    public static function entityCollectionKey(): string
    {
        return 'pedidos';
    }

    public static function sourceMapping(): array
    {
        return [
            'valor'=>'total_pedido',
        ];
    }

    public static function prepareData($data): array {

        if(isset($data['itens']) && is_array($data['itens'])) {
            $data['itens'] = array_map(fn($item) => $item['item'], $data['itens']);
        }

        if(isset($data['marcadores']) && is_array($data['marcadores'])) {
            $data['marcadores'] = array_map(fn($item) => $item['marcador'], $data['marcadores']);
        }

        if(isset($data['parcelas']) && is_array($data['parcelas'])) {
            $data['parcelas'] = array_map(fn($item) => $item['parcela'], $data['parcelas']);
        }

        return $data;
    }
}