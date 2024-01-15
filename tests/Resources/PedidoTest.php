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

    /**
     * @throws Exception
     */
    public function testLancarContas()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->lancarContas(1);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.lancar.contas.php');
    }

    /**
     * @throws Exception
     */
    public function testEstornarContas()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->estornarContas(1);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.estornar.contas.php');
    }

    /**
     * @throws Exception
     */
    public function testLancarEstoque()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->lancarEstoque(1);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.lancar.estoque.php');
    }

    /**
     * @throws Exception
     */
    public function testEstornarEstoque()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->estornarEstoque(1);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.estornar.estoque.php');
    }

    public function testRetrieve()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/pedido.obter.json');
        $pedido = $client->pedido->retrieve(123456);
        $this->assertLastRequest($httpClient, 'GET', 'api2/pedido.obter.php');
        $this->assertInstanceOf(Pedido::class, $pedido);
        $this->assertArrayContains([
            "id" => "123456",
            "numero" => "123",
        ], $pedido->toArray());
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testUpdate()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');

        $client->pedido->update(123456, ['numero' => 123]);

        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.alterar.php');

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);


        $this->assertArrayHasKey('pedido', $formData);

        $json = json_decode($formData['pedido'], true);

        $this->assertArrayHasKey('pedidos', $json);
        $this->assertArrayHasKey('pedido', $json['pedidos'][0]);
        $this->assertArrayHasKey('numero', $json['pedidos'][0]['pedido']);
        $this->assertEquals('POST', $request->getMethod());
    }

    public function testAlterarSituacao()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->alterarSituacao(123456, 'aprovado');
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.alterar.situacao');
    }

    public function testIncluirMarcadores()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->incluirMarcadores(123456, [
            ['marcador' => ['id' => 111222333]],
            ['marcador' => ['descricao' => 'Teste']],
        ]);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.marcadores.incluir');

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('marcadores', $formData);

        $json = json_decode($formData['marcadores'], true);
        $this->assertCount(2, $json);
        $this->assertArrayHasKey('marcador', $json[0]);
        $this->assertArrayHasKey('id', $json[0]['marcador']);
        $this->assertArrayHasKey('marcador', $json[1]);
        $this->assertArrayHasKey('descricao', $json[1]['marcador']);
    }

    public function testRemoverMarcadores()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/general.ok.json');
        $client->pedido->removerMarcadores(123456, [
            ['marcador' => ['id' => 111222333]],
            ['marcador' => ['descricao' => 'Teste']],
        ]);
        $this->assertLastRequest($httpClient, 'POST', 'api2/pedido.marcadores.remover');

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('marcadores', $formData);

        $json = json_decode($formData['marcadores'], true);
        $this->assertCount(2, $json);
        $this->assertArrayHasKey('marcador', $json[0]);
        $this->assertArrayHasKey('id', $json[0]['marcador']);
        $this->assertArrayHasKey('marcador', $json[1]);
        $this->assertArrayHasKey('descricao', $json[1]['marcador']);
    }
}