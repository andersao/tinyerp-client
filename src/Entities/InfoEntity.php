<?php

namespace Prettus\TinyERP\Entities;

class InfoEntity extends AbstractEntity
{
    public readonly string $razao_social;
    public readonly string $cnpj_cpf;
    public readonly string $fantasia;
    public readonly string $endereco;
    public readonly string $numero;
    public readonly string $bairro;
    public readonly string $complemento;
    public readonly string $cidade;
    public readonly string $estado;
    public readonly string $cep;
    public readonly string $fone;
    public readonly string $email;
    public readonly string $inscricao_estadual;
    public readonly string $regime_tributario;

    public static function entityKey(): string
    {
        return 'conta';
    }
}