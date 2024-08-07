<?php

namespace Prettus\TinyERP\Contracts;

interface Entity extends Arrayable
{
    public static function entityKey(): string;

    public static function entityCollectionKey(): ?string;
}