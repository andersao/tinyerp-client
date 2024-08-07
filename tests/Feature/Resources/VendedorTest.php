<?php

use Prettus\TinyERP\Entities\VendedorEntity;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Vendedor resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/vendedores.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/vendedores.pesquisa.php', $fixture);
        $response = $client->vendedor()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(VendedorEntity::class)
            ->and($entity->id)->toBe('46829055')
            ->and($entity->nome)->toBe('Vendedor Teste');
    });
});