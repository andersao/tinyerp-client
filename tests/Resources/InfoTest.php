<?php

namespace Prettus\TinyERP\Tests\Resources;

use PHPUnit\Framework\MockObject\Exception;
use Prettus\TinyERP\Resources\Info;
use  Prettus\TinyERP\Tests\TestCase;
use Psr\Http\Client\ClientExceptionInterface;

class InfoTest extends TestCase
{
    /**
     * @throws ClientExceptionInterface|Exception
     */
    public function testRetrieve()
    {
        list($client, $httpClient) = $this->tinyClientSut();

        $this->setDefaultMockResponse($httpClient, 'api2/info.json');

        $info = $client->info->retrieve();

        $this->assertLastRequest($httpClient, 'GET', 'api2/info.php');

        $expected = [
            'razao_social' => 'Empresa Ltda',
            'cnpj_cpf' => '00.000.000/0001-00',
            'fantasia' => 'Empresa',
            'endereco' => 'Rua X',
            'numero' => '18',
            'bairro' => 'Centro',
            'complemento' => 'Bloco A',
            'cidade' => 'Bento Gonçalves',
            'estado' => 'RS',
            'cep' => '95.700-000',
            'fone' => '(54) 99999-9999',
            'email' => 'tiny@tiny.com.br',
            'inscricao_estadual' => '0000000-00',
            'regime_tributario' => 'Simples Nacional',
        ];

        $this->assertInstanceOf(Info::class, $info);
        $this->assertArrayContains($expected, $info->toArray());

        foreach ($expected as $key => $value) {
            $this->assertEquals($value, $info->$key);
        }
    }
}