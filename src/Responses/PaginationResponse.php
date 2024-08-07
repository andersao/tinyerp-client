<?php

namespace Prettus\TinyERP\Responses;

/**
 * @template T
 */
class PaginationResponse
{
    /**
     * @var int
     */
    public int $page;

    /**
     * @var int
     */
    public int $total_pages;

    /**
     * @var array<int, T>
     */
    public array $items;

    /**
     * @param int $page
     * @param int $total_pages
     * @param array<int, T> $items
     */
    public function __construct(int $page, int $total_pages, array $items)
    {
        $this->page = $page;
        $this->total_pages = $total_pages;
        $this->items = $items;
    }

    /**
     * @return array<int, T>
     */
    public function items(): array
    {
        return $this->items;
    }
}