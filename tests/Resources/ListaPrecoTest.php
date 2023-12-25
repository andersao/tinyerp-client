<?php

namespace Prettus\TinyERP\Tests\Resources;

use Prettus\TinyERP\Resources\GrupoTag;
use Prettus\TinyERP\Resources\ListaPreco;
use Prettus\TinyERP\Tests\TestCase;

class ListaPrecoTest extends TestCase
{
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/listas.precos.pesquisa.json');

        $listas = $client->listaPreco->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/listas.precos.pesquisa.php');
        $this->assertAllInstanceOf(ListaPreco::class, $listas);

        $this->assertArrayContains([
            "id" => 117991558,
            "descricao" => "Amigos",
            "acrescimo_desconto" => -5,
        ], $listas[0]->toArray());
    }
}