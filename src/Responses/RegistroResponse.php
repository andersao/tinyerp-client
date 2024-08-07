<?php

namespace Prettus\TinyERP\Responses;

readonly class RegistroResponse
{
    public function __construct(
        public int $sequencia,
        public string $status,
        public ?int   $id,
        public ?int   $codigo_erro = null,
        public ?array $erros = null
    )
    {
    }
}