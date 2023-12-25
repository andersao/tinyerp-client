<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Contato;
use Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class ContatoTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testSearch()
    {
        list($client, $httpClient) = $this->TinyERPSut();
        $this->setDefaultMockResponse($httpClient, 'api2/contatos.pesquisa.json');

        $contatos = $client->contato->search();

        $this->assertLastRequest($httpClient, 'GET', 'api2/contatos.pesquisa.php');
        $this->assertAllInstanceOf(Contato::class, $contatos);

        $this->assertArrayContains([
            "id" => 46829055,
            "codigo" => 123,
            "nome" => "Contato Teste",
            "tipo_pessoa" => "F",
            "fantasia" => "Teste",
            "cpf_cnpj" => "00000000000",
            "endereco" => "Rua Teste",
            "numero" => "123",
            "complemento" => "sala 1",
            "bairro" => "Centro",
            "cep" => "95700-000",
            "cidade" => "Bento Gonçalves",
            "uf" => "RS",
            "email" => "teste@teste.com.br",
            "situacao" => "Ativo",
            "id_vendedor" => "123456",
            "nome_vendedor" => "Vendedor Teste",
            "data_criacao" => ""
        ], $contatos[0]->toArray());
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testRetrieve()
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $this->setDefaultMockResponse($httpClient, 'api2/contatos.obter.json');

        $contato = $client->contato->retrieve(68790116);

        $this->assertLastRequest($httpClient, 'GET', 'api2/contatos.obter.php');
        $this->assertInstanceOf(Contato::class, $contato);
        $this->assertArrayContains([
            "id" => "68790116",
            "codigo" => "",
            "nome" => "Contato Teste 3",
            "fantasia" => "",
            "tipo_pessoa" => "F",
            "cpf_cnpj" => "814.134.138-38",
            "ie" => "",
            "rg" => "",
            "im" => null,
            "endereco" => "Rua Teste",
            "numero" => "123",
            "complemento" => "sala 2",
            "bairro" => "Teste",
            "cep" => "95.700-000",
            "cidade" => "Bento Gonçalves",
            "uf" => "RS",
            "pais" => "",
            "endereco_cobranca" => "",
            "numero_cobranca" => "",
            "complemento_cobranca" => "",
            "bairro_cobranca" => "",
            "cep_cobranca" => "",
            "cidade_cobranca" => "",
            "uf_cobranca" => " ",
            "contatos" => "Pessoa Teste",
            "fone" => "(54) 3055-3808",
            "fax" => "",
            "celular" => "",
            "email" => "teste@teste.com.br",
            "email_nfe" => "",
            "site" => "",
            "crt" => "0",
            "estadoCivil" => "0",
            "profissao" => "",
            "sexo" => "",
            "data_nascimento" => "",
            "naturalidade" => "",
            "nome_pai" => "",
            "cpf_pai" => "",
            "nome_mae" => "",
            "cpf_mae" => "",
            "limite_credito" => 0,
            "situacao" => "A",
            "obs" => "",
            "data_atualizacao" => "21/03/2020 15:14:03",
        ], $contato->toArray());
    }

    /**
     * @throws Exception
     * @throws ClientExceptionInterface
     */
    public function testCreate()
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $this->setDefaultMockResponse($httpClient, 'api2/contato.incluir.json');

        $payload = [
            "sequencia" => "1",
            "codigo" => "1235",
            "nome" => "Contato Teste 2",
            "tipo_pessoa" => "F",
            "cpf_cnpj" => "22755777850",
            "ie" => "",
            "rg" => "1234567890",
            "im" => "",
            "endereco" => "Rua Teste",
            "numero" => "123",
            "complemento" => "sala 2",
            "bairro" => "Teste",
            "cep" => "95700-000",
            "cidade" => "Bento Gonçalves",
            "uf" => "RS",
            "pais" => "",
            "contatos" => "Contato Teste",
            "fone" => "(54) 3055 3808",
            "fax" => "",
            "celular" => "",
            "email" => "teste@teste.com.br",
            "id_vendedor" => "123",
            "situacao" => "A",
            "obs" => "teste de obs",
            "contribuinte" => "1"
        ];

        $contato = $client->contato->create($payload);

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('contato', $formData);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringEndsWith('api2/contato.incluir.php', $request->getUri()->getPath());
        $this->assertInstanceOf(Contato::class, $contato);

        $requestPayload = json_decode($formData['contato'], true);

        $this->assertEquals(49644545, $contato->id);
        $this->assertArrayContains($payload, $contato->toArray());
        $this->assertArrayContains($requestPayload, [
            'contatos' => [['contato' => $payload]]
        ]);
    }

    /**
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function testUpdate()
    {
        list($client, $httpClient) = $this->TinyERPSut();

        $httpClient->setDefaultResponse(
            $this->mockFixtureResponse('api2/contato.alterar.json')
        );

        $payload = [
            "sequencia" => "1",
            "id" => "49644545",
            "codigo" => "1234",
            "nome" => "Contato Teste 1 Alterado",
            "situacao" => "A"
        ];

        $contato = $client->contato->update(49644545, $payload);

        $request = $httpClient->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);

        $this->assertArrayHasKey('contato', $formData);
        $this->assertEquals('POST', $request->getMethod());
        $this->assertStringEndsWith('api2/contato.alterar.php', $request->getUri()->getPath());
        $this->assertInstanceOf(Contato::class, $contato);
        $this->assertEquals(49644545, $contato->id);
    }
}