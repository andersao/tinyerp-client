<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\GrupoTag;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class GrupoTagTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $this->setDefaultMockResponse($httpClient, 'api2/grupo.tag.pesquisa.json');

        $grupos = $client->grupoTag->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/grupo.tag.pesquisa.php');
        $this->assertAllInstanceOf(GrupoTag::class, $grupos);

        $this->assertArrayContains([
            "id" => "37644487",
            "nome" => "Grupo Teste 2",
        ], $grupos[0]->toArray());
    }
}