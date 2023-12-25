<?php

namespace Prettus\TinyERP\Resources;


/**
 * @property int $id
 * @property string $nome
 */
class ListaPreco extends ApiResource
{
    const RESOURCE_NAME = 'lista.precos';
    const RESOURCE_NAME_PLURAL = 'listas.precos';
    const ENTITY_ROOT_KEY = 'registro';
    const ENTITY_COLLECTION_KEY = 'registros';

    use Actions\Search;
}