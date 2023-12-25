<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\CRM;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class CRMTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();
        $this->setDefaultMockResponse($httpClient, 'api2/crm.pesquisa.json');

        $data = $client->crm->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/crm.pesquisa.php');
        $this->assertAllInstanceOf(CRM::class, $data);

        $this->assertArrayContains([
            "id" => 123456,
            "cliente" => "Cliente Teste",
            "estagio_cliente" => "C",
            "texto_assunto" => "Teste",
            "proxima_acao" => "Ligar",
            "tipo_data_acao" => "D",
            "data_acao" => "10/01/2015",
            "estagio_assunto" => "2",
            "situacao_assunto" => "A"
        ], $data[0]->toArray());
    }
}