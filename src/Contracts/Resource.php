<?php

namespace Prettus\TinyERP\Contracts;

interface Resource
{
    public function entityKey(): string;

    public function entityCollectionKey(): ?string;

    public function formParamName(): ?string;

    public function formElementCollectionName(): ?string;

    public function formElementName(): ?string;
}