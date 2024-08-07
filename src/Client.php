<?php

namespace Prettus\TinyERP;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\QueryParam;
use Prettus\TinyERP\Http\HttpClientFactory;
use Prettus\TinyERP\Resources\ContaPagarResource;
use Prettus\TinyERP\Resources\ContaReceberResource;
use Prettus\TinyERP\Resources\ContatoResource;
use Prettus\TinyERP\Resources\GrupoTagResource;
use Prettus\TinyERP\Resources\InfoResource;
use Prettus\TinyERP\Resources\ListaPrecoResource;
use Prettus\TinyERP\Resources\PedidoResource;
use Prettus\TinyERP\Resources\ProdutoResource;
use Prettus\TinyERP\Resources\TagResource;
use Prettus\TinyERP\Resources\VendedorResource;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
    protected ClientInterface $httpClient;

    public function __construct(protected string $token, ?ClientInterface $httpClient = null, ?array $plugins = [])
    {
        if (empty(trim($this->token))) {
            throw new \InvalidArgumentException('Token is required');
        }

        $this->httpClient = HttpClientFactory::make(
            client: $httpClient,
            plugins: array_merge($plugins, [new AuthenticationPlugin(new QueryParam(['token' => $this->token, 'formato' => 'json']))])
        );
    }

    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function get(string $uri, array $query = []): ResponseInterface
    {
        $message = Psr17FactoryDiscovery::findRequestFactory();
        $uri = $uri . '?' . http_build_query($query);
        return $this->httpClient->sendRequest($message->createRequest('GET', $uri));
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function post(string $uri, array $data = [], array $query = []): ResponseInterface
    {
        // create a post request as form data
        $message = Psr17FactoryDiscovery::findRequestFactory();
        $uri = $uri . '?' . http_build_query($query);
        $request = $message->createRequest('POST', $uri)->withBody($message->createStream($data));
        return $this->httpClient->sendRequest($request);
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function postForm(string $uri, array $data = [], array $query = []): ResponseInterface
    {
        $stream = Psr17FactoryDiscovery::findStreamFactory()->createStream(http_build_query($data));
        $message = Psr17FactoryDiscovery::findRequestFactory();
        $uri = $uri . '?' . http_build_query($query);
        $request = $message->createRequest('POST', $uri)
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded')
            ->withBody($stream);

        return $this->httpClient->sendRequest($request);
    }

    public function info(): InfoResource
    {
        return new InfoResource($this);
    }

    public function contato(): ContatoResource
    {
        return new ContatoResource($this);
    }

    public function grupoTag(): GrupoTagResource
    {
        return new GrupoTagResource($this);
    }

    public function tag(): TagResource
    {
        return new TagResource($this);
    }

    public function pedido(): PedidoResource
    {
        return new PedidoResource($this);
    }

    public function listaPreco(): ListaPrecoResource
    {
        return new ListaPrecoResource($this);
    }

    public function vendedor(): VendedorResource
    {
        return new VendedorResource($this);
    }

    public function contaPagar(): ContaPagarResource
    {
        return new ContaPagarResource($this);
    }

    public function contaReceber(): ContaReceberResource
    {
        return new ContaReceberResource($this);
    }

    public function produto(): ProdutoResource
    {
        return new ProdutoResource($this);
    }
}