<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Expedicao;
use Prettus\TinyERP\Resources\NotaFiscal;
use Prettus\TinyERP\Resources\Separacao;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class SeparacaoTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/separacao.pesquisa.json');

        $data = $client->separacao->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/separacao.pesquisa.php');
        $this->assertAllInstanceOf(Separacao::class, $data);

        $this->assertArrayContains([
            "id" => "444371693",
            "idOrigem" => "444325243",
            "objOrigem" => "venda",
            "situacao" => "1",
            "dataCriacao" => "11/08/2022",
            "dataSeparacao" => null,
            "dataCheckout" => null,
            "destinatario" => "Carlos Teste 123",
            "idContato" => "442817471",
            "numero" => "129",
            "dataEmissao" => "04/08/2022",
            "idFormaEnvio" => "443556202",
            "numeroPedidoEcommerce" => "",
            "idOrigemVinc" => "0",
            "objOrigemVinc" => "notafiscal",
            "situacaoVenda" => "4"
        ], $data[0]->toArray());
    }
}