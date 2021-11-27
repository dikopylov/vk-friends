<?php

namespace App\Vk\Response;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FriendsResponse
{
    public function __construct(private array $friends, private array $mutualFriends, private int $perPage)
    {
    }

    public function getItems(): array
    {
        return $this->friends[ResponseOptions::ITEMS];
    }

    public function getCount(): int
    {
        return $this->friends[ResponseOptions::COUNT];
    }

    public function getMutual(): array
    {
        return $this->mutualFriends;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
