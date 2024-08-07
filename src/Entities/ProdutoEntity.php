<?php

namespace Prettus\TinyERP\Entities;

class ProdutoEntity extends AbstractEntity
{
    public readonly ?string $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $unidade;
    public readonly ?string $preco;
    public readonly ?string $preco_promocional;
    public readonly ?string $ncm;
    public readonly ?string $origem;
    public readonly ?string $gtin;
    public readonly ?string $gtin_embalagem;
    public readonly ?string $localizacao;
    public readonly ?string $peso_liquido;
    public readonly ?string $peso_bruto;
    public readonly ?string $estoque_minimo;
    public readonly ?string $estoque_maximo;
    public readonly ?string $id_fornecedor;
    public readonly ?string $codigo_fornecedor;
    public readonly ?string $codigo_pelo_fornecedor;
    public readonly ?string $unidade_por_caixa;
    public readonly ?string $preco_custo;
    public readonly ?string $preco_custo_medio;
    public readonly ?string $situacao;
    public readonly ?string $tipo;
    public readonly ?string $classe_ipi;
    public readonly ?string $valor_ipi_fixo;
    public readonly ?string $cod_lista_servicos;
    public readonly ?string $descricao_complementar;
    public readonly ?string $obs;
    public readonly ?string $garantia;
    public readonly ?string $cest;
    public readonly ?string $tipoVariacao;
    public readonly ?string $idProdutoPai;
    public readonly ?string $sob_encomenda;
    public readonly ?string $marca;
    public readonly ?string $tipoEmbalagem;
    public readonly ?string $alturaEmbalagem;
    public readonly ?string $comprimentoEmbalagem;
    public readonly ?string $larguraEmbalagem;
    public readonly ?string $diametroEmbalagem;
    public readonly ?string $categoria;
    public readonly ?string $classe_produto;

    /**
     * @var ProdutoVariacao[]|null $variacoes
     */
    public readonly ?array $variacoes;

    /**
     * @var ProdutoImagem[]|null $imagens
     */
    public readonly ?array $imagens;

    public static function entityKey(): string
    {
        return 'produto';
    }

    public static function entityCollectionKey(): string
    {
        return 'produtos';
    }

    public static function prepareData($data): array {

        $imagens = [];

        if(isset($data['variacoes']) && is_array($data['variacoes'])) {
            $data['variacoes'] = array_map(fn($item) => $item['variacao'], $data['variacoes']);
        }

        if(isset($data['anexos']) && is_array($data['anexos'])) {
            $urls = array_map(fn($item) => ['url'=>$item['anexo'], 'externa'=>false], $data['anexos']);
            $imagens = array_merge($imagens, $urls);
        }

        if(isset($data['imagens_externas']) && is_array($data['imagens_externas'])) {
            $urls = array_map(fn($item) => ['url'=>$item['imagem_externa']['url'],  'externa'=>true], $data['imagens_externas']);
            $imagens = array_merge($imagens, $urls);
        }

        if($imagens) {
            $data['imagens'] = $imagens;
        }

        return $data;
    }
}