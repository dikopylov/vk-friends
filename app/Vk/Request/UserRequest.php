<?php

namespace App\Vk\Request;

class UserRequest extends Request
{
    private ?array $fields  = [];
    private array  $userIds = [];

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getUserIds(): array
    {
        return $this->userIds;
    }

    /**
     * @param array|null $fields
     */
    public function setFields(?array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @param array $userIds
     */
    public function setUserIds(array $userIds): void
    {
        $this->userIds = $userIds;
    }

    public function toArray(): array
    {
        $result = [];

        if ($this->fields) {
            $result[RequestOptions::FIELDS] = implode(',', $this->fields);
        }

        if ($this->userIds) {
            $result[RequestOptions::USERS_ID] = $this->userIds;
        }

        return $result;
    }

}
