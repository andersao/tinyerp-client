<?php

namespace Prettus\TinyERP\Entities;

class ContatoPessoaEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $nome;
    public readonly ?string $telefone;
    public readonly ?string $email;
    public readonly ?string $ramal;
    public readonly ?string $departamento;

    public static function sourceMapping(): array
    {
        return [
            'id_pessoa'=>'id',
        ];
    }
}