<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\NotaFiscal;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class NotaFiscalTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/notas.fiscais.pesquisa.json');

        $data = $client->notaFiscal->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/notas.fiscais.pesquisa.php');
        $this->assertAllInstanceOf(NotaFiscal::class, $data);

        $this->assertArrayContains([
            "id" => "439995226",
            "tipo" => "S",
            "serie" => "1",
            "numero" => "000148",
            "numero_ecommerce" => null,
            "data_emissao" => "11/01/2018",
            "nome" => "henrique teste 1",
        ], $data[0]->toArray());
    }
}