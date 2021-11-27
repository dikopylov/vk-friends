<?php

namespace App\Vk\Entities;

class Friend
{
    public function __construct(
        private string $firstName,
        private string $lastName,
        private int $id,
        private string $avatar,
        private ?int $countMutualFriends = null
    ) {
    }

    public function getCountMutualFriends(): ?int
    {
        return $this->countMutualFriends;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getFullName(): string
    {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    /**
     * @param int $countMutualFriends
     */
    public function setCountMutualFriends(int $countMutualFriends): void
    {
        $this->countMutualFriends = $countMutualFriends;
    }
}
