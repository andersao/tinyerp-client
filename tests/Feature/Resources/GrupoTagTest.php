<?php

use Prettus\TinyERP\Entities\GrupoTagEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Grupo tag resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/grupo.tag.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/grupo.tag.pesquisa.php', $fixture);
        $response = $client->grupoTag()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(GrupoTagEntity::class)
            ->and($entity->id)->toBe(37644487)
            ->and($entity->nome)->toBe('Grupo Teste 2');
    });

    it('should create', function () {
        $fixture = loadFixture('response/grupo.tag.incluir.json');
        list($client, $http) = mockTinyClient('POST', '/api2/grupo.tag.incluir.php', $fixture);

        $response = $client->grupoTag()->create([
            'nome' => 'Grupo Teste 2',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['grupo'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toBeArray()
            ->and($data)->toHaveKey('grupos_tag')
            ->and($data['grupos_tag'][0])->toHaveKey('grupo_tag');

        $grupo = $data['grupos_tag'][0]['grupo_tag'];

        expect($grupo)->toHaveKeys(['nome', 'sequencia']);

        $records = $response->data();
        $record = $records[0];

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($records)->toBeArray()
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(37644488);
    });

    it('should update', function () {
        $fixture = loadFixture('response/grupo.tag.alterar.json');
        list($client, $http) = mockTinyClient('POST', '/api2/grupo.tag.alterar.php', $fixture);

        $response = $client->grupoTag()->update(123456, [
            'nome' => 'Grupo Teste 3',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['grupo'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toBeArray()
            ->and($data)->toHaveKey('grupos_tag')
            ->and($data['grupos_tag'][0])->toHaveKey('grupo_tag')
            ->and($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3);
    });
});