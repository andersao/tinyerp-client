<?php

namespace Prettus\TinyERP\Resources;

/**
 * @property int $id
 * @property string $codigo
 * @property string $nome
 * @property string $preco
 * @property string $preco_promocional
 * @property string $preco_custo
 * @property string $preco_custo_medio
 * @property string $unidade
 * @property string $tipoVariacao
 */
class Produto extends ApiResource
{
    const RESOURCE_NAME = 'produto';
    const RESOURCE_NAME_PLURAL = 'produtos';
    const ENTITY_ROOT_KEY = 'produto';
    const ENTITY_COLLECTION_KEY = 'produtos';

    use Actions\Search;
    use Actions\Create;
    use Actions\Update;
    use Actions\Retrieve;
}