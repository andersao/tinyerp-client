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
}