<?php

namespace Prettus\TinyERP;

use Http\Discovery\Psr17Factory;
use Prettus\TinyERP\Http\Plugin\TinyErrorPlugin;
use Prettus\TinyERP\Resources\ContaPagar;
use Prettus\TinyERP\Resources\ContaReceber;
use Prettus\TinyERP\Resources\Contato;
use Prettus\TinyERP\Resources\CRM;
use Prettus\TinyERP\Resources\Expedicao;
use Prettus\TinyERP\Resources\GrupoTag;
use Prettus\TinyERP\Resources\Info;
use Prettus\TinyERP\Resources\ListaPreco;
use Prettus\TinyERP\Resources\NotaFiscal;
use Prettus\TinyERP\Resources\Pedido;
use Prettus\TinyERP\Resources\Produto;
use Prettus\TinyERP\Resources\Separacao;
use Prettus\TinyERP\Resources\Vendedor;
use Psr\Http\Client\ClientInterface;
use Http\Discovery\Psr18ClientDiscovery as HttpClientDiscovery;
use Http\Client\Common\PluginClient;
use Http\Client\Common\Plugin\BaseUriPlugin;
use Http\Client\Common\Plugin\QueryDefaultsPlugin;

class Client
{
    protected array $options = [];
    protected string $token;
    protected string $apiBaseUrl;
    protected string $apiVersion;
    protected ClientInterface $httpClient;
    public Info $info;
    public Contato $contato;
    public Produto $produto;
    public Vendedor $vendedor;
    public ContaReceber $contaReceber;
    public ContaPagar $contaPagar;
    public Pedido $pedido;
    public GrupoTag $grupoTag;
    public ListaPreco $listaPreco;
    public CRM $crm;
    public NotaFiscal $notaFiscal;
    public Expedicao $expedicao;
    public Separacao $separacao;

    const API_BASE_URL = 'https://api.tiny.com.br';
    const API_VERSION = 'api2';

    /**
     * @param array{
     *     token: string,
     *     http_client: ClientInterface,
     *     api_base_url: string,
     *     api_version: string,
     * } $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->token = $options['token'] ?? $_ENV['TINY_TOKEN'] ?? '';
        $this->apiBaseUrl = $options['api_base_url'] ?? self::API_BASE_URL;
        $this->apiVersion = $options['api_version'] ?? self::API_VERSION;
        $this->httpClient = $this->buildHttpClient();
        $factory = new Psr17Factory();
        $this->info = new Info($this->httpClient(), $factory);
        $this->contato = new Contato($this->httpClient(), $factory);
        $this->produto = new Produto($this->httpClient(), $factory);
        $this->vendedor = new Vendedor($this->httpClient(), $factory);
        $this->contaReceber = new ContaReceber($this->httpClient(), $factory);
        $this->contaPagar = new ContaPagar($this->httpClient(), $factory);
        $this->pedido = new Pedido($this->httpClient(), $factory);
        $this->grupoTag = new GrupoTag($this->httpClient(), $factory);
        $this->listaPreco = new ListaPreco($this->httpClient(), $factory);
        $this->crm = new CRM($this->httpClient(), $factory);
        $this->notaFiscal = new NotaFiscal($this->httpClient(), $factory);
        $this->expedicao = new Expedicao($this->httpClient(), $factory);
        $this->separacao = new Separacao($this->httpClient(), $factory);

        if (empty($this->token)) {
            throw new \InvalidArgumentException('Token is required');
        }
    }

    protected function buildHttpClient(): ClientInterface
    {
        $factory = new Psr17Factory();
        $client = $this->options['http_client'] ?? HttpClientDiscovery::find();
        $uri = sprintf('%s/%s', $this->apiBaseUrl, $this->apiVersion);

        $plugins = [
            new BaseUriPlugin($factory->createUri($uri), ['replace' => true,]),
            new QueryDefaultsPlugin(['token' => $this->token, 'formato' => 'json']),
            new TinyErrorPlugin()
        ];

        return new PluginClient($client, $plugins);
    }

    protected function httpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getApiBaseUrl(): string
    {
        return $this->apiBaseUrl;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }
}