<?php

namespace Prettus\TinyERP\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;

abstract class ApiResource implements Arrayable
{
    const ENTITY_ROOT_KEY = null;
    const ENTITY_COLLECTION_KEY = null;

    protected array $values = [];

    public function __construct(
        protected ClientInterface         $client,
        protected RequestFactoryInterface $requestFactory,
    )
    {
    }

    public function __toString(): string
    {
        return json_encode($this->values);
    }

    public function __isset($name)
    {
        return isset($this->values[$name]);
    }

    public function __set($name, $value)
    {
        $this->values[$name] = $value;
    }

    public function __get($name)
    {
        return $this->values[$name] ?? null;
    }

    public function __clone(): void
    {
        $this->values = [];
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public static function resourceName(): string
    {
        return static::RESOURCE_NAME;
    }

    public static function resourceNamePlural(): string
    {
        return static::RESOURCE_NAME_PLURAL;
    }

    public static function entityRootKey(): ?string
    {
        return static::ENTITY_ROOT_KEY;
    }

    public static function entityCollectionKey(): ?string
    {
        return static::ENTITY_COLLECTION_KEY;
    }
}