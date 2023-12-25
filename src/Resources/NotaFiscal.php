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
class NotaFiscal extends ApiResource
{
    const RESOURCE_NAME = 'notas.fiscais';
    const RESOURCE_NAME_PLURAL = 'notas.fiscais';
    const ENTITY_ROOT_KEY = 'nota_fiscal';
    const ENTITY_COLLECTION_KEY = 'notas_fiscais';

    use Actions\Search;
    use Actions\Retrieve;
    use Actions\Create;
}