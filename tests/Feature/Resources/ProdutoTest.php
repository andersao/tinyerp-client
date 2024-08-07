<?php

use Prettus\TinyERP\Entities\ContaPagarEntity;
use Prettus\TinyERP\Entities\ProdutoEntity;
use Prettus\TinyERP\Entities\ProdutoEstoqueEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Produto resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/produtos.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/produtos.pesquisa.php', $fixture);
        $response = $client->produto()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(ProdutoEntity::class)
            ->and($entity->id)->toBe('46829062')
            ->and($entity->codigo)->toBe('123')
            ->and($entity->nome)->toBe('produto teste')
            ->and($entity->preco)->toBe('1.20')
            ->and($entity->preco_promocional)->toBe('1.10')
            ->and($entity->preco_custo)->toBe('1.05')
            ->and($entity->preco_custo_medio)->toBe('1.02')
            ->and($entity->unidade)->toBe('UN')
            ->and($entity->tipoVariacao)->toBe('P');
    });

    it('should retrieve', function () {
        $fixture = loadFixture('response/produto.obter.json');
        list($client) = mockTinyClient('GET', '/api2/produto.obter.php', $fixture);
        $response = $client->produto()->retrieve(349112581);
        $entity = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($entity)->toBeInstanceOf(ProdutoEntity::class)
            ->and($entity->id)->toBe('349112581')
            ->and($entity->codigo)->toBe('123')
            ->and($entity->nome)->toBe('produto teste')
            ->and($entity->unidade)->toBe('UN')
            ->and($entity->preco)->toBe('0')
            ->and($entity->preco_promocional)->toBe('0')
            ->and($entity->ncm)->toBe('')
            ->and($entity->origem)->toBe('0')
            ->and($entity->gtin)->toBe('')
            ->and($entity->gtin_embalagem)->toBe('')
            ->and($entity->localizacao)->toBe('')
            ->and($entity->peso_liquido)->toBe('0')
            ->and($entity->peso_bruto)->toBe('0')
            ->and($entity->estoque_minimo)->toBe('0')
            ->and($entity->estoque_maximo)->toBe('0')
            ->and($entity->id_fornecedor)->toBe('0')
            ->and($entity->codigo_fornecedor)->toBe('')
            ->and($entity->codigo_pelo_fornecedor)->toBe('')
            ->and($entity->unidade_por_caixa)->toBe('')
            ->and($entity->preco_custo)->toBe('0')
            ->and($entity->preco_custo_medio)->toBe('0')
            ->and($entity->situacao)->toBe('A')
            ->and($entity->tipo)->toBe('P')
            ->and($entity->classe_ipi)->toBe('')
            ->and($entity->valor_ipi_fixo)->toBe('0')
            ->and($entity->cod_lista_servicos)->toBe('')
            ->and($entity->descricao_complementar)->toBe('')
            ->and($entity->obs)->toBe('')
            ->and($entity->garantia)->toBe('')
            ->and($entity->cest)->toBe('01.003.00')
            ->and($entity->tipoVariacao)->toBe('P')
            ->and($entity->idProdutoPai)->toBe('')
            ->and($entity->sob_encomenda)->toBe('S')
            ->and($entity->marca)->toBe('Marca do produto')
            ->and($entity->tipoEmbalagem)->toBe('2')
            ->and($entity->alturaEmbalagem)->toBe('26.50')
            ->and($entity->comprimentoEmbalagem)->toBe('27.42')
            ->and($entity->larguraEmbalagem)->toBe('28.00')
            ->and($entity->diametroEmbalagem)->toBe('0.00')
            ->and($entity->categoria)->toBe('Categoria pai >> Categoria filha')
            ->and($entity->classe_produto)->toBe('V')
            ->and($entity->variacoes)->toBeArray()
            ->and($entity->variacoes)->toHaveCount(2)
            ->and($entity->imagens)->toBeArray()
            ->and($entity->imagens)->toHaveCount(4);

        $variacao = $entity->variacoes[0];
        $imagem = $entity->imagens[0];

        expect($variacao)->toBeInstanceOf(\Prettus\TinyERP\Entities\ProdutoVariacao::class)
            ->and($variacao->id)->toBe('323221231')
            ->and($variacao->codigo)->toBe('123 - 1')
            ->and($variacao->preco)->toBe('36.3200000000')
            ->and($variacao->grade)->toBeArray()
            ->and($variacao->grade)->toHaveKeys(['Cor', 'Tamanho'])
            ->and($imagem)->toBeInstanceOf(\Prettus\TinyERP\Entities\ProdutoImagem::class)
            ->and($imagem->url)->toBe('http://minhalojavirtualtiny.com.br/images/45221.jpg')
            ->and($imagem->externa)->toBeFalse();
    });

    it('should create', function () {
        $fixture = loadFixture('response/produto.incluir.json');
        list($client, $http) = mockTinyClient('POST', '/api2/produto.incluir.php', $fixture);
        $response = $client->produto()->create([
            'codigo' => '1234',
            'nome' => 'Produto Teste 1',
            'tags' => ["1234"],
        ]);
        $records = $response->data();
        $record = $records[0];

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['produto'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('produtos')
            ->and($data['produtos'])->toHaveCount(1)
            ->and($data['produtos'][0])->toHaveKey('produto');

        $produto = $data['produtos'][0]['produto'];

        expect($produto)->toHaveKeys(['sequencia', 'codigo', 'nome', 'tags'])
            ->and($produto['codigo'])->toBe('1234')
            ->and($produto['nome'])->toBe('Produto Teste 1')
            ->and($produto['tags'])->toBeArray()
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(49644544);
    });

    it('should update', function () {
        $fixture = loadFixture('response/produto.alterar.json');
        list($client, $http) = mockTinyClient('POST', '/api2/produto.alterar.php', $fixture);
        $response = $client->produto()->update(123, [
            'codigo' => '1234',
            'nome' => 'Produto Teste 1',
            'tags' => ["1234"],
        ]);

        $records = $response->data();
        $record = $records[0];

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['produto'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('produtos')
            ->and($data['produtos'])->toHaveCount(1)
            ->and($data['produtos'][0])->toHaveKey('produto');

        $produto = $data['produtos'][0]['produto'];

        expect($produto)->toHaveKeys(['sequencia', 'codigo', 'nome', 'tags'])
            ->and($produto['codigo'])->toBe('1234')
            ->and($produto['nome'])->toBe('Produto Teste 1')
            ->and($produto['tags'])->toBeArray()
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(49644544);
    });

    it('should get stock', function () {
        $fixture = loadFixture('response/produto.obter.estoque.json');
        list($client) = mockTinyClient('GET', '/api2/produto.obter.estoque.php', $fixture);
        $entity = $client->produto()->getStock(123);

        expect($entity)->toBeInstanceOf(ProdutoEstoqueEntity::class)
            ->and($entity->id)->toBe(46829062)
            ->and($entity->codigo)->toBe('123')
            ->and($entity->nome)->toBe('produto teste')
            ->and($entity->unidade)->toBe('UN')
            ->and($entity->saldo)->toBe(10.0)
            ->and($entity->saldoReservado)->toBe(3.0)
            ->and($entity->depositos)->toBeArray();

        $deposito = $entity->depositos[0];

        expect($deposito)->toBeInstanceOf(\Prettus\TinyERP\Entities\Deposito::class)
            ->and($deposito->nome)->toBe('Deposito 1')
            ->and($deposito->saldo)->toBe(5.0)
            ->and($deposito->desconsiderar)->toBe('N')
            ->and($deposito->empresa)->toBe('Tiny');
    });

    it('should get tags', function () {
        $fixture = loadFixture('response/produto.obter.tags.json');
        list($client) = mockTinyClient('GET', '/api2/produto.obter.tags', $fixture);
        $tags = $client->produto()->getTags(123);
        $tag = $tags[0];

        expect($tags)->toBeArray()
            ->and($tag->id)->toBe(7399555)
            ->and($tag->nome)->toBe('Azul');
    });

    it('should get modified', function () {
        $fixture = loadFixture('response/lista.atualizacoes.produtos.json');
        list($client) = mockTinyClient('GET', '/api2/lista.atualizacoes.produtos', $fixture);
        $produtos = $client->produto()->getModified([]);
        $produto = $produtos[0];

        expect($produtos)->toBeArray()
            ->and($produtos)->toHaveCount(2)
            ->and($produto->id)->toBe('46829062')
            ->and($produto->nome)->toBe('produto teste');
    });
});