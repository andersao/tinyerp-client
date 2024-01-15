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
    const ENTITY_ROOT_KEY = 'conta';
    const ENTITY_COLLECTION_KEY = 'contas';

    use Actions\Search;
    use Actions\Create;
    use Actions\Retrieve;

    public function baixar(array $data): bool
    {
        $uri = sprintf('/%s.baixar.php', static::resourceName());

        $body = http_build_query([
            static::entityRootKey() => json_encode([static::entityRootKey() => $data])
        ]);

        $response = $this->post($uri, $body);

        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}