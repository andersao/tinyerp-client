<?php

namespace Prettus\TinyERP\Entities;

class ProdutoVariacaoEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?float $preco;
    public readonly ?float $preco_promocional;
    public readonly ?array $grade;

    public function cor(): ?string
    {
        return $this->grade['cor'] ?? $this->grade['Cor'] ?? null;
    }

    public function tamanho(): ?string
    {
        return $this->grade['tamanho'] ?? $this->grade['Tamanho'] ?? null;
    }
}