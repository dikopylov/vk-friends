<?php

namespace App\Vk\Request;

use App\Vk\Request\RequestOptions;

class FriendsRequest extends AbstractFriendsRequest
{
    private ?int    $userId = null;
    private ?int    $page   = null;
    private ?string $fields = null;

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = implode(',', $fields);
    }

    /**
     * @param int $page
     */
    public function setPage(int $page): void
    {
        $this->page = $page;

        $offset = $this->calcOffset($page);
        $this->setOffset($offset);
    }

    /**
     * @return int|null
     */
    public function getPage(): ?int
    {
        return $this->page;
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
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function toArray(): array
    {
        $result = [];

        if ($this->count) {
            $result[RequestOptions::COUNT] = $this->count;
        }

        if ($this->fields) {
            $result[RequestOptions::FIELDS] = $this->fields;
        }

        if ($this->offset) {
            $result[RequestOptions::OFFSET] = $this->offset;
        }


        return $result;
    }


}
