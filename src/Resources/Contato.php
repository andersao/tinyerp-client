<?php

namespace Prettus\TinyERP\Resources;

/**
 * @property int $id
 * @property int $codigo
 * @property string $nome
 * @property string $tipo_pessoa
 * @property string $fantasia
 * @property string $cpf_cnpj
 * @property string $endereco
 * @property string $numero
 * @property string $complemento
 * @property string $bairro
 * @property string $cep
 * @property string $cidade
 * @property string $uf
 * @property string $email
 * @property string $situacao
 * @property string $id_vendedor
 * @property string $nome_vendedor
 * @property string $data_criacao
 */
class Contato extends ApiResource
{
    const RESOURCE_NAME = 'contato';
    const RESOURCE_NAME_PLURAL = 'contatos';
    const ENTITY_ROOT_KEY = 'contato';
    const ENTITY_COLLECTION_KEY = 'contatos';

    use Actions\Search;
    use Actions\Retrieve;
    use Actions\Create;
    use Actions\Update;
}