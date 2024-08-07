<?php

use Prettus\TinyERP\Entities\TagEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Tag resource', function () {

    it('should search', function () {
        $fixture = loadFixture('response/tag.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/tag.pesquisa.php', $fixture);
        $response = $client->tag()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(TagEntity::class)
            ->and($entity->id)->toBe(46829060)
            ->and($entity->nome)->toBe('nova');
    });

    it('should create', function () {
        $fixture = loadFixture('response/tag.incluir.json');
        list($client, $http) = mockTinyClient('POST', '/api2/tag.incluir.php', $fixture);

        $response = $client->tag()->create([
            'nome' => 'Grupo Teste 2',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['tag'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toBeArray()
            ->and($data)->toHaveKey('tags')
            ->and($data['tags'][0])->toHaveKey('tag');

        $grupo = $data['tags'][0]['tag'];

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
            ->and($record->id)->toBe(37644487);
    });

    it('should update', function () {
        $fixture = loadFixture('response/tag.alterar.json');
        list($client, $http) = mockTinyClient('POST', '/api2/tag.alterar.php', $fixture);

        $response = $client->tag()->update(123456, [
            'nome' => 'Grupo Teste 3',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['tag'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toBeArray()
            ->and($data)->toHaveKey('tags')
            ->and($data['tags'][0])->toHaveKey('tag')
            ->and($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3);
    });
});