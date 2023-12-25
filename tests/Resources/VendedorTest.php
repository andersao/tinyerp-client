<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Vendedor;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class VendedorTest extends TestCase
{
    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/vendedores.pesquisa.json');

        $vendedores = $client->vendedor->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/vendedores.pesquisa.php');
        $this->assertAllInstanceOf(Vendedor::class, $vendedores);

        $this->assertArrayContains([
            "id" => 46829055,
            "codigo" => 123,
            "nome" => "Vendedor Teste",
            "tipo_pessoa" => "F",
            "fantasia" => "Teste",
            "cpf_cnpj" => "00000000000",
            "email" => "vendedor_teste@mail.com",
            "endereco" => "Rua Teste",
            "numero" => "123",
            "complemento" => "sala 1",
            "bairro" => "Centro",
            "cep" => "95700-000",
            "cidade" => "Bento Gonçalves",
            "uf" => "RS",
            "situacao" => "Ativo"
        ], $vendedores[0]->toArray());
    }
}