<?php

namespace Prettus\TinyERP\Entities;

class ContaPagarEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?ContaCliente $cliente;
    public readonly ?string $data;
    public readonly ?string $vencimento;
    public readonly ?string $emissao;
    public readonly ?float $valor;
    public readonly ?float $saldo;
    public readonly ?string $nro_documento;
    public readonly ?string $competencia;
    public readonly ?string $historico;
    public readonly ?string $categoria;
    public readonly ?string $situacao;
    public readonly ?string $ocorrencia;
    public readonly ?string $dia_vencimento;

    public static function prepareData($data): array {

        if(isset($data['nome_cliente'])) {
            $data['cliente'] = ['nome' => $data['nome_cliente']];
        }

        return $data;
    }

    public static function sourceMapping(): array
    {
        return [
            'numero_doc'=>'nro_documento',
            'data_vencimento'=>'vencimento',
            'data_emissao'=>'emissao',
            'data'=>'emissao',
        ];
    }
}