<?php

namespace App\Vk\Response;

class UserResponse
{
    public function __construct(private array $users)
    {
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}
