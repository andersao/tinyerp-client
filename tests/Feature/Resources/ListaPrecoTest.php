<?php

use Prettus\TinyERP\Entities\ListaPrecoEntity;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Lista preco resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/listas.precos.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/listas.precos.pesquisa.php', $fixture);
        $response = $client->listaPreco()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(ListaPrecoEntity::class)
            ->and($entity->id)->toBe(117991558)
            ->and($entity->descricao)->toBe('Amigos')
            ->and($entity->acrescimo_desconto)->toBe(-5);
    });
});