<?php

namespace App\Vk\Response;

class MutualFriendsResponse
{
    public function __construct(private array $mutualFriends)
    {
    }

    public function getCommonIDs(): array
    {
        return $this->mutualFriends[0][ResponseOptions::COMMON_FRIENDS];
    }

    public function getCountCommon(): int
    {
        return $this->mutualFriends[0][ResponseOptions::COMMON_COUNT];
    }

    public function isEmpty(): bool
    {
        return $this->getCountCommon() === 0;
    }

}
