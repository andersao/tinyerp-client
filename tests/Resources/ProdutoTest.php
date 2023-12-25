<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Produto;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class ProdutoTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/produtos.pesquisa.json');

        $produtos = $client->produto->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/produtos.pesquisa.php');
        $this->assertAllInstanceOf(Produto::class, $produtos);

        $this->assertArrayContains([
            "id" => 46829062,
            "codigo" => 123,
            "nome" => "produto teste",
            "preco" => "1.20",
            "preco_promocional" => "1.10",
            "preco_custo" => "1.05",
            "preco_custo_medio" => "1.02",
            "unidade" => "UN",
            "tipoVariacao" => "P"
        ], $produtos[0]->toArray());
    }
}