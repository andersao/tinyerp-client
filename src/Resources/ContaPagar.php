<?php

namespace Prettus\TinyERP\Resources;

/**
 * @property int $id
 * @property string $nome_cliente
 * @property string $historico
 * @property string $numero_doc
 * @property string $data_vencimento
 * @property string $data_emissao
 * @property float $valor
 * @property float $saldo
 * @property string $situacao
 */
class ContaPagar extends ApiResource
{
    const RESOURCE_NAME = 'conta.pagar';
    const RESOURCE_NAME_PLURAL = 'contas.pagar';
    const ENTITY_ROOT_KEY = null;
    const ENTITY_COLLECTION_KEY = 'contas';

    use Actions\Search;
    use Actions\Create;
    use Actions\Retrieve;
}