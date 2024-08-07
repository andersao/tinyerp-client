<?php

use Prettus\TinyERP\Entities\ContatoEntity;
use Prettus\TinyERP\Responses\RegistroResponse;
use Prettus\TinyERP\Responses\RetornoResponse;

describe('Contato resource', function () {
    it('should search', function () {
        $fixture = loadFixture('response/contatos.pesquisa.json');
        list($client) = mockTinyClient('GET', '/api2/contatos.pesquisa.php', $fixture);
        $response = $client->contato()->search();
        $entities = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($response->pagina)->toBe(1)
            ->and($response->numero_paginas)->toBe(1)
            ->and($entities)->toBeArray()
            ->and($entities)->toHaveCount(2);

        $entity = $entities[0];

        expect($entity)->toBeInstanceOf(ContatoEntity::class)
            ->and($entity->id)->toBe(46829055)
            ->and($entity->codigo)->toBe('123')
            ->and($entity->nome)->toBe('Contato Teste')
            ->and($entity->tipo_pessoa)->toBe('F')
            ->and($entity->fantasia)->toBe('Teste')
            ->and($entity->cpf_cnpj)->toBe('00000000000')
            ->and($entity->endereco)->toBe('Rua Teste')
            ->and($entity->numero)->toBe('123')
            ->and($entity->complemento)->toBe('sala 1')
            ->and($entity->bairro)->toBe('Centro')
            ->and($entity->cep)->toBe('95700-000')
            ->and($entity->cidade)->toBe('Bento Gonçalves')
            ->and($entity->uf)->toBe('RS')
            ->and($entity->email)->toBe('teste@teste.com.br')
            ->and($entity->situacao)->toBe('Ativo')
            ->and($entity->id_vendedor)->toBe('123456')
            ->and($entity->nome_vendedor)->toBe('Vendedor Teste')
            ->and($entity->data_criacao)->toBe('');
    });

    it('should retrieve', function () {
        $fixture = loadFixture('response/contato.obter.json');
        list($client) = mockTinyClient('GET', '/api2/contato.obter.php', $fixture);
        $response = $client->contato()->retrieve(68790116);
        $entity = $response->data();

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($entity)->toBeInstanceOf(ContatoEntity::class)
            ->and($entity->id)->toBe(68790116)
            ->and($entity->codigo)->toBe("")
            ->and($entity->nome)->toBe("Contato Teste 3")
            ->and($entity->fantasia)->toBe("")
            ->and($entity->tipo_pessoa)->toBe("F")
            ->and($entity->cpf_cnpj)->toBe("814.134.138-38")
            ->and($entity->ie)->toBe("")
            ->and($entity->rg)->toBe("")
            ->and($entity->im)->toBe(null)
            ->and($entity->endereco)->toBe("Rua Teste")
            ->and($entity->numero)->toBe("123")
            ->and($entity->complemento)->toBe("sala 2")
            ->and($entity->bairro)->toBe("Teste")
            ->and($entity->cep)->toBe("95.700-000")
            ->and($entity->cidade)->toBe("Bento Gonçalves")
            ->and($entity->uf)->toBe("RS")
            ->and($entity->pais)->toBe("")
            ->and($entity->endereco_cobranca)->toBe("")
            ->and($entity->numero_cobranca)->toBe("")
            ->and($entity->complemento_cobranca)->toBe("")
            ->and($entity->bairro_cobranca)->toBe("")
            ->and($entity->cep_cobranca)->toBe("")
            ->and($entity->cidade_cobranca)->toBe("")
            ->and($entity->uf_cobranca)->toBe(" ")
            ->and($entity->contatos)->toBe("Pessoa Teste")
            ->and($entity->fone)->toBe("(54) 3055-3808")
            ->and($entity->fax)->toBe("")
            ->and($entity->celular)->toBe("")
            ->and($entity->email)->toBe("teste@teste.com.br")
            ->and($entity->email_nfe)->toBe("")
            ->and($entity->site)->toBe("")
            ->and($entity->crt)->toBe("0")
            ->and($entity->estado_civil)->toBe("0")
            ->and($entity->profissao)->toBe("")
            ->and($entity->sexo)->toBe("")
            ->and($entity->data_nascimento)->toBe("")
            ->and($entity->naturalidade)->toBe("")
            ->and($entity->nome_pai)->toBe("")
            ->and($entity->cpf_pai)->toBe("")
            ->and($entity->nome_mae)->toBe("")
            ->and($entity->cpf_mae)->toBe("")
            ->and($entity->limite_credito)->toBe(0.0)
            ->and($entity->situacao)->toBe("A")
            ->and($entity->obs)->toBe("")
            ->and($entity->data_atualizacao)->toBe("21/03/2020 15:14:03")
            ->and($entity->tipos_contato)->toBeArray();
    });

    it('should create', function () {
        $fixture = loadFixture('response/contato.incluir.ok.json');
        list($client, $http) = mockTinyClient('POST', '/api2/contato.incluir.php', $fixture);

        $response = $client->contato()->create([
            'codigo' => '123',
            'cpf_cnpj' => '00000000000',
            'nome' => 'Contato Teste',
            'situacao' => 'A',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['contato'], true);


        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('contatos')
            ->and($data['contatos'])->toBeArray()
            ->and($data['contatos'])->toHaveCount(1)
            ->and($data['contatos'][0])->toHaveKey('contato');

        $contato = $data['contatos'][0]['contato'];

        expect($contato)->toHaveKeys(['codigo', 'cpf_cnpj', 'nome', 'situacao'])
            ->and($contato['codigo'])->toBe('123')
            ->and($contato['cpf_cnpj'])->toBe('00000000000')
            ->and($contato['nome'])->toBe('Contato Teste')
            ->and($contato['situacao'])->toBe('A');

        $records = $response->data();
        $record = $records[0];

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($records)->toBeArray()
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(49644545);
    });

    it('should update', function () {
        $fixture = loadFixture('response/contato.alterar.ok.json');
        list($client, $http) = mockTinyClient('POST', '/api2/contato.alterar.php', $fixture);

        $response = $client->contato()->update(49644545, [
            'codigo' => '123',
            'cpf_cnpj' => '00000000000',
            'nome' => 'Contato Teste',
            'situacao' => 'A',
        ]);

        $request = $http->getLastRequest();
        parse_str(urldecode($request->getBody()->getContents()), $formData);
        $data = json_decode($formData['contato'], true);

        expect($request->getMethod())->toBe('POST')
            ->and($data)->toHaveKey('contatos')
            ->and($data['contatos'])->toBeArray()
            ->and($data['contatos'])->toHaveCount(1)
            ->and($data['contatos'][0])->toHaveKey('contato');

        $contato = $data['contatos'][0]['contato'];

        expect($contato)->toHaveKeys(['id', 'codigo', 'cpf_cnpj', 'nome', 'situacao'])
            ->and($contato['id'])->toBe(49644545)
            ->and($contato['codigo'])->toBe('123')
            ->and($contato['cpf_cnpj'])->toBe('00000000000')
            ->and($contato['nome'])->toBe('Contato Teste')
            ->and($contato['situacao'])->toBe('A');

        $records = $response->data();
        $record = $records[0];

        expect($response)->toBeInstanceOf(RetornoResponse::class)
            ->and($response->status)->toBe('OK')
            ->and($response->status_processamento)->toBe(3)
            ->and($records)->toBeArray()
            ->and($record)->toBeInstanceOf(RegistroResponse::class)
            ->and($record->sequencia)->toBe(1)
            ->and($record->status)->toBe("OK")
            ->and($record->id)->toBe(49644545);
    });
});