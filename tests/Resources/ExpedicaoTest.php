<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Expedicao;
use Prettus\TinyERP\Resources\NotaFiscal;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class ExpedicaoTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $this->setDefaultMockResponse($httpClient, 'api2/expedicao.pesquisa.json');

        $data = $client->expedicao->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/expedicao.pesquisa.php');
        $this->assertAllInstanceOf(Expedicao::class, $data);

        $this->assertArrayContains([
            "id" => "440183098",
            "tipoObjeto" => "venda",
            "idObjeto" => "440183093",
            "idAgrupamento" => "0",
            "situacao" => "0",
            "dataEmissao" => "28/02/2018",
            "formaEnvio" => "C",
            "identificacao" => "Pedido 1000557",
            "qtdVolumes" => "0",
            "valorDeclarado" => "25,94",
            "possuiValorDeclarado" => "S",
            "pesoBruto" => "0,000",
            "codigoRastreamento" => "SG021791790BR",
            "urlRastreamento" => "",
            "possuiAR" => "N",
        ], $data[0]->toArray());
    }
}