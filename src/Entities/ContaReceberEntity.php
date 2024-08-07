<?php

namespace Prettus\TinyERP\Entities;


class ContaReceberEntity extends AbstractEntity
{
    public readonly ?string $id;
    public readonly ?string $emissao;
    public readonly ?string $vencimento;
    public readonly ?string $nome_cliente;
    public readonly ?string $valor;
    public readonly ?string $saldo;
    public readonly ?string $nro_documento;
    public readonly ?string $serie_documento;
    public readonly ?string $nro_banco;
    public readonly ?string $competencia;
    public readonly ?string $historico;
    public readonly ?string $categoria;
    public readonly ?string $portador;
    public readonly ?string $situacao;
    public readonly ?string $ocorrencia;
    public readonly ?string $dia_vencimento;
    public readonly ?string $forma_pagamento;

    public static function entityKey(): string
    {
        return 'tag';
    }

    public static function entityCollectionKey(): string
    {
        return 'tags';
    }

    public static function sourceMapping(): array
    {
        return [
            'serie_doc'=> 'serie_documento',
            'numero_banco'=>'nro_banco',
            'numero_doc'=>'nro_documento',
            'data_vencimento'=>'vencimento',
            'data_emissao'=>'emissao',
            'data'=>'emissao',
        ];
    }
}