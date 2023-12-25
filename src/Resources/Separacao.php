<?php

namespace Prettus\TinyERP\Resources;

/**
 * @property int $id
 * @property int $codigo
 * @property string $nome
 * @property string $tipo_pessoa
 * @property string $fantasia
 * @property string $cpf_cnpj
 * @property string $email
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cep
 * @property string $cidade
 * @property string $uf
 * @property string $situacao
 */
class Separacao extends ApiResource
{
    const RESOURCE_NAME = 'separacao';
    const RESOURCE_NAME_PLURAL = 'separacao';
    const ENTITY_COLLECTION_KEY = 'separacoes';

    use Actions\Search;
    use Actions\Retrieve;
}