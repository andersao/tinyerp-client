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
class Pedido extends ApiResource
{
    const RESOURCE_NAME = 'pedido';
    const RESOURCE_NAME_PLURAL = 'pedidos';
    const ENTITY_ROOT_KEY = 'pedido';
    const ENTITY_COLLECTION_KEY = 'pedidos';

    use Actions\Search;
    use Actions\Retrieve;
    use Actions\Update;
    use Actions\Create;

    public function lancarContas(int|string $id): bool {
        $uri = sprintf('/%s.lancar.contas.php?id=%s', static::resourceName(), $id);
        $response = $this->post($uri);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function estornarContas(int|string $id): bool {
        $uri = sprintf('/%s.estornar.contas.php?id=%s', static::resourceName(), $id);
        $response = $this->post($uri);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function lancarEstoque(int|string $id): bool {
        $uri = sprintf('/%s.lancar.estoque.php?id=%s', static::resourceName(), $id);
        $response = $this->post($uri);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function estornarEstoque(int|string $id): bool {
        $uri = sprintf('/%s.estornar.estoque.php?id=%s', static::resourceName(), $id);
        $response = $this->post($uri);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function alterarSituacao(int|string $id, string $situacao): bool
    {
        $uri = sprintf('/%s.alterar.situacao?situacao=%s&id=%s', static::resourceName(), $situacao, $id);
        $response = $this->post($uri);
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function incluirMarcadores(int|string $id, array $marcadores): bool
    {
        $uri = sprintf('/%s.marcadores.incluir?idPedido=%s', static::resourceName(), $id);
        $response = $this->post($uri, http_build_query(['marcadores' => json_encode($marcadores)]));
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public function removerMarcadores(int|string $id, array $marcadores): bool
    {
        $uri = sprintf('/%s.marcadores.remover?idPedido=%s', static::resourceName(), $id);
        $response = $this->post($uri, http_build_query(['marcadores' => json_encode($marcadores)]));
        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }
}