<?php

namespace Prettus\TinyERP\Traits;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use CuyZ\Valinor\MapperBuilder;

trait HasMapperBuilder
{
    /**
     * @throws MappingError
     */
    public static function from($data): static
    {
        return static::treeMapper()
            ->map(static::class, static::source(static::prepareData($data)));
    }

    public static function mapperBuilder(): MapperBuilder
    {
        $mapper = new \CuyZ\Valinor\MapperBuilder();
        return $mapper
            ->allowSuperfluousKeys()
            ->enableFlexibleCasting()
            ->allowPermissiveTypes();
    }

    public static function treeMapper(): TreeMapper
    {
        return static::mapperBuilder()->mapper();
    }

    public static function sourceMapping(): array
    {
        return [];
    }

    public static function source($data): Source
    {
        return static::arraySource($data)->map(static::sourceMapping());
    }

    public static function prepareData($data): array {
        return $data;
    }

    public static function arraySource($data): Source
    {
        return \CuyZ\Valinor\Mapper\Source\Source::array($data);
    }

    public function toArray(): array
    {
        $normalizer = (new \CuyZ\Valinor\MapperBuilder())
            ->normalizer(\CuyZ\Valinor\Normalizer\Format::array());

        return $normalizer->normalize($this);
    }
}