<?php

namespace Prettus\TinyERP\Http;
use Http\Client\Common\Plugin\ErrorPlugin;
use Http\Client\Common\PluginClient;
use Http\Discovery\Psr18ClientDiscovery;
use Prettus\TinyERP\Http\Plugin\TinyErrorPlugin;
use Psr\Http\Client\ClientInterface;

final class HttpClientFactory
{
    public static function make(
        ?ClientInterface $client = null,
        ?array $plugins = []
    ): ClientInterface
    {
        if (!$client) $client = Psr18ClientDiscovery::find();

        $plugins[] = new ErrorPlugin();
        $plugins[] = new TinyErrorPlugin();

        return new PluginClient($client, $plugins);
    }
}