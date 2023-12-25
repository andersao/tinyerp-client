<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Pedido;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class PedidoTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/pedidos.pesquisa.json');

        $pedidos = $client->pedido->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/pedidos.pesquisa.php');
        $this->assertAllInstanceOf(Pedido::class, $pedidos);

        $this->assertArrayContains([
            "id" => 123456,
            "numero" => 123456,
            "numero_ecommerce" => "12",
            "data_pedido" => "01/01/2013",
            "data_prevista" => "10/01/2013",
            "nome" => "Cliente Teste",
            "valor" => "100.25",
            "id_vendedor" => "123456",
            "nome_vendedor" => "Vendedor Teste",
            "situacao" => "Atendido"
        ], $pedidos[0]->toArray());
    }
}