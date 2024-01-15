<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\ContaPagar;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class ContaPagarTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/contas.pagar.pesquisa.json');

        $contas = $client->contaPagar->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/contas.pagar.pesquisa.php');
        $this->assertAllInstanceOf(ContaPagar::class, $contas);
        $this->assertArrayContains([
            "id" => "5489125",
            "nome_cliente" => "henrique teste 2",
            "historico" => "Ref. a NF nº 000453, henrique teste 2 (parcela 1/1)",
            "numero_doc" => "000453/01",
            "data_vencimento" => "08/07/2015",
            "data_emissao" => "10/07/2015",
            "valor" => "6.00",
            "saldo" => "1.00",
            "situacao" => "parcial"
        ], $contas[0]->toArray());
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testCreate()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/conta.pagar.incluir.json');

        $payload = [
            "cliente" => ["codigo" => 123],
            "vencimento" => "25/11/2015",
            "valor" => 54.44,
            "nro_documento" => "",
            "historico" => "teste teste xxx lalala \n\n\n\t\t\t\t\nxaalkxalxal",
            "categoria" => "Faxina",
            "ocorrencia" => "P",
            "dia_vencimento" => "4",
            "numero_parcelas" => "4"
        ];

        $conta = $client->contaPagar->create($payload);

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('conta', $formData);
        $this->assertArrayHasKey('conta', $formData['conta']);
        $this->assertArrayHasKey('cliente', $formData['conta']['conta']);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringEndsWith('api2/conta.pagar.incluir.php', $request->getUri()->getPath());
        $this->assertInstanceOf(ContaPagar::class, $conta);
        $this->assertNotNull($conta->id);
        $this->assertArrayContains($payload, $conta->toArray());
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testBaixar()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $payload = [
            "id" => "350187089",
            "contaDestino" => "Caixa",
            "data" => "10/10/2016",
            "categoria" => "Água, Luz",
            "historico" => "historico de teste",
            "valorTaxas" => 4.3,
            "valorJuros" => 3.5,
            "valorDesconto" => 6.4,
            "valorAcrescimo" => 3.3,
            "valorPago" => 35.5
        ];

        $baixado = $client->contaPagar->baixar($payload);

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('conta', $formData);

        $json = json_decode($formData['conta'], true);

        $this->assertArrayHasKey('conta', $json);
        $this->assertArrayHasKey('id', $json['conta']);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringEndsWith('api2/conta.pagar.baixar.php', $request->getUri()->getPath());
        $this->assertTrue($baixado);
    }
}