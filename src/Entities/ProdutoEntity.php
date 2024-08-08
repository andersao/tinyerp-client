<?php

namespace Prettus\TinyERP\Entities;

class ProdutoEntity extends AbstractEntity
{
    public readonly ?int $id;
    public readonly ?string $codigo;
    public readonly ?string $nome;
    public readonly ?string $unidade;
    public readonly ?float $preco;
    public readonly ?float $preco_promocional;
    public readonly ?string $ncm;
    public readonly ?int $origem;
    public readonly ?string $gtin;
    public readonly ?string $gtin_embalagem;
    public readonly ?string $localizacao;
    public readonly ?float $peso_liquido;
    public readonly ?float $peso_bruto;
    public readonly ?float $estoque_minimo;
    public readonly ?float $estoque_maximo;
    public readonly ?int $id_fornecedor;
    public readonly ?string $codigo_fornecedor;
    public readonly ?string $codigo_pelo_fornecedor;
    public readonly ?string $unidade_por_caixa;
    public readonly ?float $preco_custo;
    public readonly ?float $preco_custo_medio;
    public readonly ?string $situacao;
    public readonly ?string $tipo;
    public readonly ?string $classe_ipi;
    public readonly ?float $valor_ipi_fixo;
    public readonly ?string $cod_lista_servicos;
    public readonly ?string $descricao_complementar;
    public readonly ?string $obs;
    public readonly ?string $garantia;
    public readonly ?string $cest;
    public readonly ?string $tipo_variacao;
    public readonly ?int $id_produto_pai;
    public readonly ?string $sob_encomenda;
    public readonly ?string $marca;
    public readonly ?int $tipo_embalagem;
    public readonly ?float $altura_embalagem;
    public readonly ?float $comprimento_embalagem;
    public readonly ?float $largura_embalagem;
    public readonly ?float $diametro_embalagem;
    public readonly ?string $categoria;
    public readonly ?string $classe_produto;

    /**
     * @var ProdutoVariacaoEntity[]|null $variacoes
     */
    public readonly ?array $variacoes;

    /**
     * @var ProdutoImagemEntity[]|null $imagens
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

    public static function sourceMapping(): array
    {
        return [
            'tipoVariacao'=>'tipo_variacao',
            'idProdutoPai'=>'id_produto_pai',
            'sobEncomenda'=>'sob_encomenda',
            'tipoEmbalagem'=>'tipo_embalagem',
            'alturaEmbalagem'=>'altura_embalagem',
            'comprimentoEmbalagem'=>'comprimento_embalagem',
            'larguraEmbalagem'=>'largura_embalagem',
            'diametroEmbalagem'=>'diametro_embalagem',
        ];
    }

    public static function prepareData($data): array {

        $imagens = [];

        if(isset($data['idProdutoPai'])) {
            $data['idProdutoPai'] = !empty($data['idProdutoPai']) ? $data['idProdutoPai'] : null;
        }

        if(isset($data['variacoes'])) {
            if(is_array($data['variacoes'])) {
                $data['variacoes'] = array_map(fn($item) => $item['variacao'], $data['variacoes']);
            } else {
                $data['variacoes'] = [];
            }
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