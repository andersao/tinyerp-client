<?php

namespace Prettus\TinyERP\Responses;

/**
 * @template T
 */
readonly class RetornoResponse
{
    /**
     * @param string $status
     * @param int $status_processamento
     * @param T $data
     * @param int|null $pagina
     * @param int|null $numero_paginas
     */
    public function __construct(
        public string  $status,
        public int     $status_processamento,
        public mixed   $data,
        public ?int    $pagina = null,
        public ?int    $numero_paginas = null
    )
    {
    }

    /**
     * @return T
     */
    public function data(): mixed
    {
        return $this->data;
    }
}