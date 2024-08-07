<?php

namespace Prettus\TinyERP\Contracts;

interface TinyEntity
{
    public static function entityKey(): string;
    public static function entityCollectionKey(): ?string;
}