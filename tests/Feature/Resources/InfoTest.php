<?php

use Prettus\TinyERP\Entities\InfoEntity;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Info resource', function () {
    it('should retrieve account info', function () {
        $fixture = loadFixture('response/info.json');
        list($client) = mockTinyClient('GET', '/api2/info.php', $fixture);
        $response = $client->info()->get();
        $entity = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBeNull()
            ->and($entity)->toBeInstanceOf(InfoEntity::class)
            ->and($entity)->toHaveProperty('razao_social')
            ->and($entity->razao_social)->toBe('Empresa Ltda')
            ->and($entity->cnpj_cpf)->toBe('00.000.000/0001-00')
            ->and($entity->fantasia)->toBe('Empresa')
            ->and($entity->endereco)->toBe('Rua X')
            ->and($entity->numero)->toBe('18')
            ->and($entity->bairro)->toBe('Centro')
            ->and($entity->complemento)->toBe('Bloco A')
            ->and($entity->cidade)->toBe('Bento Gonçalves')
            ->and($entity->estado)->toBe('RS')
            ->and($entity->cep)->toBe('95.700-000')
            ->and($entity->fone)->toBe('(54) 99999-9999')
            ->and($entity->email)->toBe('tiny@tiny.com.br')
            ->and($entity->inscricao_estadual)->toBe('0000000-00')
            ->and($entity->regime_tributario)->toBe('Simples Nacional');
    });
});