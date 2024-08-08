<?php

namespace Prettus\TinyERP\Entities;

class ContatoEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $tipo_pessoa;
    public readonly ?string $fantasia;
    public readonly ?string $cpf_cnpj;
    public readonly ?string $ie;
    public readonly ?string $rg;
    public readonly ?string $im;
    public readonly ?string $endereco;
    public readonly ?string $numero;
    public readonly ?string $complemento;
    public readonly ?string $bairro;
    public readonly ?string $cep;
    public readonly ?string $cidade;
    public readonly ?string $uf;
    public readonly ?string $pais;
    public readonly ?string $endereco_cobranca;
    public readonly ?string $numero_cobranca;
    public readonly ?string $complemento_cobranca;
    public readonly ?string $bairro_cobranca;
    public readonly ?string $cep_cobranca;
    public readonly ?string $cidade_cobranca;
    public readonly ?string $uf_cobranca;
    public readonly ?string $contatos;
    public readonly ?string $fone;
    public readonly ?string $fax;
    public readonly ?string $celular;
    public readonly ?string $email;
    public readonly ?string $email_nfe;
    public readonly ?string $site;
    public readonly ?string $crt;
    public readonly ?string $estado_civil;
    public readonly ?string $profissao;
    public readonly ?string $sexo;
    public readonly ?string $data_nascimento;
    public readonly ?string $naturalidade;
    public readonly ?string $nome_pai;
    public readonly ?string $cpf_pai;
    public readonly ?string $nome_mae;
    public readonly ?string $cpf_mae;
    public readonly ?float $limite_credito;
    public readonly ?string $situacao;
    public readonly ?string $id_vendedor;
    public readonly ?string $nome_vendedor;
    public readonly ?string $data_criacao;
    public readonly ?string $obs;
    public readonly ?string $data_atualizacao;
    public readonly ?array $tipos_contato;

    /**
     * @var ContatoPessoaEntity[]|null
     */
    public readonly ?array $pessoas_contato;

    public static function entityKey(): string
    {
        return 'contato';
    }

    public static function entityCollectionKey(): string
    {
        return 'contatos';
    }

    public static function prepareData($data): array {
        if(isset($data['pessoas_contato']) && is_array($data['pessoas_contato'])) {
            $data['pessoas_contato'] = array_map(fn($item) => [
                ...$item['pessoa_contato'],
                'id' => $item['id_pessoa'],
            ], $data['pessoas_contato']);
        }

        if(isset($data['tipos_contato']) && is_array($data['tipos_contato'])) {
            $data['tipos_contato'] = array_map(fn($item) => $item['tipo'], $data['tipos_contato']);
        }

        return $data;
    }

    public static function sourceMapping(): array
    {
        return [
            'estadoCivil'=>'estado_civil',
        ];
    }
}