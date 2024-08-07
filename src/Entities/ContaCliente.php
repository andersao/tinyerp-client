<?php

namespace Prettus\TinyERP\Entities;


class ContaCliente extends AbstractEntity
{
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $tipo_pessoa;
    public readonly ?string $fantasia;
    public readonly ?string $cpf_cnpj;
    public readonly ?string $ie;
    public readonly ?string $rg;
    public readonly ?string $endereco;
    public readonly ?string $numero;
    public readonly ?string $complemento;
    public readonly ?string $bairro;
    public readonly ?string $cep;
    public readonly ?string $cidade;
    public readonly ?string $uf;
    public readonly ?string $pais;
    public readonly ?string $fone;
    public readonly ?string $email;
}