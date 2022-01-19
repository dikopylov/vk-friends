<?php

namespace App\Builders;

use App\Exceptions\InvalidStructureException;
use App\Vk\Entities\Friend;
use App\Vk\Response\ResponseOptions;
use ErrorException;
use Illuminate\Support\Str;
use Throwable;

use function collect;

class FriendsBuilder
{
    private array $friends = [];

    /**
     * @param array $rawFriends
     *
     * @return FriendsBuilder
     * @throws InvalidStructureException
     * @throws ErrorException
     * @throws Throwable
     */
    public function buildFriends(array $rawFriends): static
    {
        try {
            /**
             * @param array{first_name: string, last_name:string, id:string, avatar: string} $rawFriend
             */
            foreach ($rawFriends as $rawFriend) {
                $this->friends[] = new Friend(
                    firstName: (string)$rawFriend[ResponseOptions::FIRST_NAME],
                    lastName: (string)$rawFriend[ResponseOptions::LAST_NAME],
                    id: (int)$rawFriend[ResponseOptions::ID],
                    avatar: (string)$rawFriend[ResponseOptions::AVATAR],
                );
            }
        } catch (Throwable $exception) {
            if (Str::contains($exception->getMessage(), 'Undefined array key')) {
                throw new InvalidStructureException(
                    'Structure must be contains next field: ' . ResponseOptions::ID . ', ' . ResponseOptions::LAST_NAME . ', ' . ResponseOptions::FIRST_NAME . ', ' . ResponseOptions::AVATAR
                );
            }

            throw $exception;
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
        $collectMutualFriends = collect($rawMutualFriends)->keyBy(ResponseOptions::ID);

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
