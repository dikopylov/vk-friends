<?php

namespace App\Vk\Request;

use App\Vk\Request\RequestOptions;

abstract class AbstractFriendsRequest extends Request
{
    protected ?int $count  = null;
    protected ?int $offset = null;

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $offset = $this->calcOffset($page);

        $this->setOffset($offset);
    }

    /**
     * @param int $offset
     */
    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int $page
     *
     * @return float|int
     */
    protected function calcOffset(int $page): int|float
    {
        return (($page - 1) * RequestOptions::DEFAULT_PAGINATION_ITEMS) ?? RequestOptions::DEFAULT_PAGINATION_ITEMS;
    }
}
