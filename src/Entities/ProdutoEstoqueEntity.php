<?php

namespace Prettus\TinyERP\Entities;

use Prettus\TinyERP\Traits\HasMapperBuilder;

class ProdutoEstoqueEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $unidade;
    public readonly ?float $saldo;
    public readonly ?float $saldoReservado;
    /**
     * @var DepositoEntity[]
     */
    public readonly ?array $depositos;

    public static function prepareData($data): array {

        if(isset($data['depositos']) && is_array($data['depositos'])) {
            $data['depositos'] = array_map(fn($item) => $item['deposito'], $data['depositos']);
        }

        return $data;
    }
}