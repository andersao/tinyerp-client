<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\PedidoEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class PedidoResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<PedidoEntity>
     */
    use SearchOperation;
    use CreateOperation;
    use UpdateOperation;

    /**
     * @use RetrieveOperation<PedidoEntity>
     */
    use RetrieveOperation;

    public function entityClass(): string
    {
        return PedidoEntity::class;
    }

    public function updateFormParamName() : ?string
    {
        return 'dados_pedido';
    }

    public function updateFormElementCollectionName() : ?string
    {
        return null;
    }

    public function updateFormElementName() : ?string
    {
        return null;
    }

    public function updateFormParams(mixed $id, array $data = []): array
    {
        return ['dados_pedido' => json_encode(array_merge(['id' => $id], $data))];
    }

    public function updateStatus(int $id, string $situacao): void
    {
        $endpoint = sprintf('https://api.tiny.com.br/api2/pedido.alterar.situacao.php?id=%s&situacao=%s', $id, $situacao);
        $this->client->post($endpoint);
    }

    public function lancarEstoque(int $id): void
    {
        $endpoint = sprintf('https://api.tiny.com.br/api2/pedido.lancar.estoque.php?id=%s', $id);
        $this->client->post($endpoint);
    }

    public function lancarContas(int $id): void
    {
        $endpoint = sprintf('https://api.tiny.com.br/api2/pedido.lancar.contas.php?id=%s', $id);
        $this->client->post($endpoint);
    }
}