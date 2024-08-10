<?php

namespace Prettus\TinyERP\Resources;

use Prettus\TinyERP\Entities\CategoriaEntity;
use Prettus\TinyERP\Entities\ProdutoAlteradoEntity;
use Prettus\TinyERP\Entities\ProdutoEntity;
use Prettus\TinyERP\Entities\ProdutoEstoqueEntity;
use Prettus\TinyERP\Entities\TagEntity;
use Prettus\TinyERP\Resources\Concerns\ExtractResponse;
use Prettus\TinyERP\Resources\Operations\CreateOperation;
use Prettus\TinyERP\Resources\Operations\RetrieveOperation;
use Prettus\TinyERP\Resources\Operations\SearchOperation;
use Prettus\TinyERP\Resources\Operations\UpdateOperation;

class ProdutoResource extends AbstractResource
{
    use ExtractResponse;

    /**
     * @use SearchOperation<ProdutoEntity>
     */
    use SearchOperation;
    use CreateOperation;
    use UpdateOperation;

    /**
     * @use RetrieveOperation<ProdutoEntity>
     */
    use RetrieveOperation;

    public function entityClass(): string
    {
        return ProdutoEntity::class;
    }

    public function getStock(string $id): ProdutoEstoqueEntity
    {
        $endpoint = 'https://api.tiny.com.br/api2/produto.obter.estoque.php';
        $response = $this->client->get($endpoint, ['id'=>$id]);
        $body = json_decode($response->getBody()->getContents(), true);
        $retorno = $body['retorno']['produto'];
        return ProdutoEstoqueEntity::from($retorno);
    }

    public function getTags(string $id): array
    {
        $endpoint = 'https://api.tiny.com.br/api2/produto.obter.tags';
        $response = $this->client->get($endpoint, ['id'=>$id]);
        $body = json_decode($response->getBody()->getContents(), true);
        $tags = $body['retorno']['produto']['tags'];
        return array_map(fn($tag) => TagEntity::from($tag['tag']), $tags);
    }

    public function getArvoreCategorias(): array
    {
        $endpoint = 'https://api.tiny.com.br/api2/produtos.categorias.arvore.php';
        $response = $this->client->get($endpoint);
        $body = json_decode($response->getBody()->getContents(), true);
        $categorias = $body['retorno']['categorias'] ?? [];
        return array_map(fn($categoria) => CategoriaEntity::from($categoria), $categorias);
    }

    public function getModified(array $params): array
    {
        $endpoint = 'https://api.tiny.com.br/api2/lista.atualizacoes.produtos';
        $response = $this->client->get($endpoint, $params);
        $body = json_decode($response->getBody()->getContents(), true);
        $produtos = $body['retorno']['produtos'];
        return array_map(fn($item) => ProdutoAlteradoEntity::from($item['produto']), $produtos);
    }
}