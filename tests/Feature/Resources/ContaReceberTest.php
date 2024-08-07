<?php

use Prettus\TinyERP\Entities\ContaReceberEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Conta Receber resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/contas.receber.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/contas.receber.pesquisa.php', $fixture);
        $response = $client->contaReceber()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(1);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(ContaReceberEntity::class)
            ->and($entity->id)->toBe('5489125')
            ->and($entity->cliente->nome)->toBe('henrique teste 2')
            ->and($entity->historico)->toBe('Ref. a NF nº 000453, henrique teste 2 (parcela 1/1)')
            ->and($entity->nro_banco)->toBe('175/00064619-3')
            ->and($entity->nro_documento)->toBe('000453/01')
            ->and($entity->serie_documento)->toBe('2')
            ->and($entity->vencimento)->toBe('08/07/2015')
            ->and($entity->emissao)->toBe('10/07/2015')
            ->and($entity->valor)->toBe('6.00')
            ->and($entity->saldo)->toBe('1.00')
            ->and($entity->situacao)->toBe('parcial');
    });

    it('should retrieve', function () {
        $fixture = loadFixture('response/conta.receber.obter.json');
        list($client) = mockTinyClient('GET', '/api2/conta.receber.obter.php', $fixture);
        $response = $client->contaReceber()->retrieve(433224432);
        $entity = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($entity)->toBeInstanceOf(ContaReceberEntity::class)
            ->and($entity->id)->toBe('433224432')
            ->and($entity->nro_documento)->toBe('000065205')
            ->and($entity->competencia)->toBe('10/2016');
    });

    it('should create', function () {
        $fixture = loadFixture('response/conta.receber.incluir.json');
        list($client, $http) = mockTinyClient('POST', '/api2/conta.receber.incluir.php', $fixture);
        $response = $client->contaReceber()->create([
            'cliente' => ['codigo' => '123456'],
            'vencimento' => '25/11/2015',
            'valor' => 54.44,
        ]);
        $records = $response->data();
        $record = $records[0];

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['conta'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('conta')
            ->and($data['conta'])->toHaveKeys(['cliente', 'vencimento', 'valor'])
            ->and($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(49644545);
    });

    it('should update', function () {
        $fixture = loadFixture('response/conta.receber.alterar.json');
        list($client, $http) = mockTinyClient('POST', '/api2/conta.receber.alterar.php', $fixture);
        $response = $client->contaReceber()->update(123, [
            'vencimento' => '01/12/2022',
            'taxa' => 25.5,
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['conta'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('conta')
            ->and($data['conta'])->toHaveKeys(['id', 'vencimento', 'taxa'])
            ->and($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3);
    });
});