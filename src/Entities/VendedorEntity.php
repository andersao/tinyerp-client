<?php

namespace Prettus\TinyERP\Entities;


class VendedorEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $tipo_pessoa;
    public readonly ?string $fantasia;
    public readonly ?string $cpf_cnpj;
    public readonly ?string $email;
    public readonly ?string $endereco;
    public readonly ?string $numero;
    public readonly ?string $complemento;
    public readonly ?string $bairro;
    public readonly ?string $cep;
    public readonly ?string $cidade;
    public readonly ?string $uf;
    public readonly ?string $situacao;

    public static function entityKey(): string
    {
        return 'tag';
    }

    public static function entityCollectionKey(): string
    {
        return 'tags';
    }
}