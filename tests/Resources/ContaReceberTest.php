<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\ContaReceber;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class ContaReceberTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->TinyERPSut();
        $this->setDefaultMockResponse($httpClient, 'api2/contas.receber.pesquisa.json');

        $contas = $client->contaReceber->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/contas.receber.pesquisa.php');
        $this->assertAllInstanceOf(ContaReceber::class, $contas);

        $this->assertArrayContains([
            "id" => "5489125",
            "nome_cliente" => "henrique teste 2",
            "historico" => "Ref. a NF nº 000453, henrique teste 2 (parcela 1/1)",
            "numero_banco" => "175/00064619-3",
            "numero_doc" => "000453/01",
            "serie_doc" => "2",
            "data_vencimento" => "08/07/2015",
            "data_emissao" => "10/07/2015",
            "valor" => "6.00",
            "saldo" => "1.00",
            "situacao" => "parcial"
        ], $contas[0]->toArray());
    }
}