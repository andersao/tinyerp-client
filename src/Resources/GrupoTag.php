<?php

namespace Prettus\TinyERP\Resources;


/**
 * @property int $id
 * @property string $nome
 */
class GrupoTag extends ApiResource
{
    const RESOURCE_NAME = 'grupo.tag';
    const RESOURCE_NAME_PLURAL = 'grupo.tag';
    const ENTITY_ROOT_KEY = 'registro';
    const ENTITY_COLLECTION_KEY = 'registros';

    use Actions\Search;
    use Actions\Create;
    use Actions\Update;
}