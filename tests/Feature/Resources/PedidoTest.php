<?php

use Prettus\TinyERP\Entities\PedidoEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Pedido resource', function () {

    it('should search', function () {
        $fixture = loadFixture('response/pedidos.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/pedidos.pesquisa.php', $fixture);
        $response = $client->pedido()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(PedidoEntity::class)
            ->and($entity->id)->toBe(123456)
            ->and($entity->numero)->toBe('123456')
            ->and($entity->numero_ecommerce)->toBe('12')
            ->and($entity->nome)->toBe('Cliente Teste')
            ->and($entity->total_pedido)->toBe(100.25)
            ->and($entity->data_pedido)->toBe('01/01/2013')
            ->and($entity->data_prevista)->toBe('10/01/2013')
            ->and($entity->id_vendedor)->toBe(123456)
            ->and($entity->nome_vendedor)->toBe('Vendedor Teste')
            ->and($entity->situacao)->toBe('Atendido');
    });

    it('should retrieve', function () {
        $fixture = loadFixture('response/pedido.obter.json');
        list($client) = mockTinyClient('GET', '/api2/pedido.obter.php', $fixture);
        $response = $client->pedido()->retrieve(123456);
        $entity = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($entity)->toBeInstanceOf(PedidoEntity::class)
            ->and($entity->id)->toBe(123456)
            ->and($entity->numero)->toBe("123")
            ->and($entity->data_pedido)->toBe("01/01/2012")
            ->and($entity->data_prevista)->toBe("10/01/2012")
            ->and($entity->data_faturamento)->toBe("09/01/2012")
            ->and($entity->condicao_pagamento)->toBe("30 60 90")
            ->and($entity->forma_pagamento)->toBe("crediario")
            ->and($entity->meio_pagamento)->toBe("Dinheiro")
            ->and($entity->nome_transportador)->toBe("transportador teste")
            ->and($entity->frete_por_conta)->toBe("E")
            ->and($entity->valor_frete)->toBe(35.00)
            ->and($entity->valor_desconto)->toBe(35.00)
            ->and($entity->total_produtos)->toBe(161.50)
            ->and($entity->total_pedido)->toBe(161.50)
            ->and($entity->numero_ordem_compra)->toBe("123")
            ->and($entity->deposito)->toBe("Teste")
            ->and($entity->forma_envio)->toBe("C")
            ->and($entity->forma_frete)->toBe("SEDEX - CONTRATO (40436)")
            ->and($entity->situacao)->toBe("Em aberto")
            ->and($entity->obs)->toBe("Observação Teste")
            ->and($entity->id_vendedor)->toBe(0)
            ->and($entity->nome_vendedor)->toBe("")
            ->and($entity->codigo_rastreamento)->toBe("TINY90831920321BR")
            ->and($entity->url_rastreamento)->toBe("http://urlrastreamento.com.br")
            ->and($entity->id_nota_fiscal)->toBe(0)
            ->and($entity->cliente)->toBeInstanceOf(\Prettus\TinyERP\Entities\PedidoClienteEntity::class)
            ->and($entity->cliente->codigo)->toBe("1235")
            ->and($entity->cliente->nome)->toBe("Contato Teste 2")
            ->and($entity->marcadores)->toBeArray()
            ->and($entity->marcadores)->toHaveCount(1)
            ->and($entity->parcelas)->toBeArray()
            ->and($entity->parcelas)->toHaveCount(3)
            ->and($entity->itens)->toBeArray()
            ->and($entity->itens)->toHaveCount(2)
            ->and($entity->toArray())->toBeArray();

        $marcador = $entity->marcadores[0];
        $parcela = $entity->parcelas[0];
        $item = $entity->itens[0];
        $ecomm = $entity->ecommerce;

        expect($marcador->id)->toBe(149238)
            ->and($marcador->descricao)->toBe('Teste')
            ->and($marcador->cor)->toBe('#808080')
            ->and($parcela->dias)->toBe('30')
            ->and($parcela->data)->toBe('29/11/2012')
            ->and($parcela->valor)->toBe(53.84)
            ->and($parcela->obs)->toBe('Obs Parcela 1')
            ->and($item->codigo)->toBe('1234')
            ->and($item->descricao)->toBe('Produto Teste 1')
            ->and($item->unidade)->toBe('UN')
            ->and($item->quantidade)->toBe(2.0)
            ->and($item->valor_unitario)->toBe(50.25)
            ->and($ecomm->id)->toBe(112)
            ->and($ecomm->nome)->toBe('Nuvemshop')
            ->and($ecomm->numero_pedido)->toBe('125')
            ->and($ecomm->numero_pedido_canal_venda)->toBe('');
    });

    it('should create', function () {
        $fixture = loadFixture('response/pedido.incluir.json');
        list($client, $http) = mockTinyClient('POST', '/api2/pedido.incluir.php', $fixture);

        $response = $client->pedido()->create([
            'cliente' => [
                'codigo' => '123',
                'nome' => 'lorem'
            ],
            'itens' => [
                ['item' => [
                    'id_produto' => '123',
                    'descricao' => 'Produto Teste',
                ]]
            ]
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['pedido'], true);


        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('pedidos')
            ->and($data['pedidos'])->toBeArray()
            ->and($data['pedidos'])->toHaveCount(1)
            ->and($data['pedidos'][0])->toHaveKey('pedido');

        $pedido = $data['pedidos'][0]['pedido'];

        expect($pedido)->toHaveKeys(['cliente', 'itens']);

        $records = $response->data();
        $record = $records[0];

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($records)->toBeArray()
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(37644545);
    });

    it('should update', function () {
        $fixture = loadFixture('response/pedido.alterar.ok.json');
        list($client, $http) = mockTinyClient('POST', '/api2/pedido.alterar.php', $fixture);

        $response = $client->pedido()->update(49644545, [
            'data_prevista' => '01/01/2021',
            'obs' => 'lorem',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['dados_pedido'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKeys(['data_prevista', 'obs'])
            ->and($data['data_prevista'])->toBe('01/01/2021')
            ->and($data['obs'])->toBe('lorem')
            ->and($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3);
    });
});