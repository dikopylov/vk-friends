<?php

namespace App\Builders;

use App\Vk\Entities\Friend;
use App\Vk\Response\ResponseOptions;
use function collect;

class FriendsBuilder
{
    private array $friends = [];

    /**
     * @param array $rawFriends
     *
     * @return FriendsBuilder
     */
    public function buildFriends(array $rawFriends): static
    {
        /**
         * @param array{first_name: string, last_name:string, id:string, avatar: string} $rawFriend
         */
        foreach ($rawFriends as $rawFriend) {
            $this->friends[] = new Friend(
                firstName:          $rawFriend[ResponseOptions::FIRST_NAME],
                lastName:           $rawFriend[ResponseOptions::LAST_NAME],
                id:                 $rawFriend[ResponseOptions::ID],
                avatar:             $rawFriend[ResponseOptions::AVATAR],
            );
        }

        return $this;
    }

    /**
     * @param array $rawMutualFriends
     *
     * @return FriendsBuilder
     */
    public function buildCountMutual(array $rawMutualFriends): static
    {
        $collectMutualFriends = collect($rawMutualFriends)->keyBy('id');

        foreach ($this->friends as $friend) {
            $rawMutualFriend = $collectMutualFriends->offsetGet($friend->getId());

            $friend->setCountMutualFriends($rawMutualFriend[ResponseOptions::COMMON_COUNT]);
        }

        return $this;
    }

    public function getResult(): array
    {
        return $this->friends;
    }
}
