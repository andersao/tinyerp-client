<?php

namespace Prettus\TinyERP\Resources;


/**
 * @property int $id
 * @property string $nome
 */
class CRM extends ApiResource
{
    const RESOURCE_NAME = 'crm';
    const RESOURCE_NAME_PLURAL = 'crm';
    const ENTITY_ROOT_KEY = 'assunto';
    const ENTITY_COLLECTION_KEY = 'assuntos';

    use Actions\Search;
    use Actions\Retrieve;
    use Actions\Create;
    use Actions\Update;
}