<?php

namespace Tests\Unit\Builders;

use App\Builders\FriendsBuilder;
use App\Exceptions\InvalidStructureException;
use App\Vk\Entities\Friend;
use App\Vk\Response\ResponseOptions;
use Tests\Unit\UnitTestCase;

class FriendsBuilderTest extends UnitTestCase
{

    public function testBuildFriends_hasRawArrayFriends_returnFriendArray()
    {
        $rawFriends = [
            [
                ResponseOptions::FIRST_NAME => $this->faker->name,
                ResponseOptions::LAST_NAME  => $this->faker->name,
                ResponseOptions::ID         => $this->faker->randomNumber(),
                ResponseOptions::AVATAR     => $this->faker->imageUrl,
            ],
            [
                ResponseOptions::FIRST_NAME => $this->faker->name,
                ResponseOptions::LAST_NAME  => $this->faker->name,
                ResponseOptions::ID         => $this->faker->randomNumber(),
                ResponseOptions::AVATAR     => $this->faker->imageUrl,
            ],
        ];

        $actual = (new FriendsBuilder)->buildFriends($rawFriends)->getResult();

        $expected = [
            new Friend(
                $rawFriends[0][ResponseOptions::FIRST_NAME],
                $rawFriends[0][ResponseOptions::LAST_NAME],
                $rawFriends[0][ResponseOptions::ID],
                $rawFriends[0][ResponseOptions::AVATAR],
            ),
            new Friend(
                $rawFriends[1][ResponseOptions::FIRST_NAME],
                $rawFriends[1][ResponseOptions::LAST_NAME],
                $rawFriends[1][ResponseOptions::ID],
                $rawFriends[1][ResponseOptions::AVATAR],
            ),
        ];

        static::assertEquals($expected, $actual);
    }

    public function testBuildCountMutual_hasArrayFriends_returnFriendArray()
    {
        $rawFriends = [
            [
                ResponseOptions::FIRST_NAME => $this->faker->name,
                ResponseOptions::LAST_NAME  => $this->faker->name,
                ResponseOptions::ID         => $this->faker->randomNumber(),
                ResponseOptions::AVATAR     => $this->faker->imageUrl,
            ],
            [
                ResponseOptions::FIRST_NAME => $this->faker->name,
                ResponseOptions::LAST_NAME  => $this->faker->name,
                ResponseOptions::ID         => $this->faker->randomNumber(),
                ResponseOptions::AVATAR     => $this->faker->imageUrl,
            ],
        ];

        $rawMutualFriends = [
            [
                ResponseOptions::ID           => $rawFriends[0][ResponseOptions::ID],
                ResponseOptions::COMMON_COUNT => $this->faker->randomDigit(),
            ],
            [
                ResponseOptions::ID           => $rawFriends[1][ResponseOptions::ID],
                ResponseOptions::COMMON_COUNT => $this->faker->randomDigit(),
            ],
        ];

        $actual = (new FriendsBuilder)->buildFriends($rawFriends)
            ->buildCountMutual($rawMutualFriends)
            ->getResult();

        $expected = [
            new Friend(
                $rawFriends[0][ResponseOptions::FIRST_NAME],
                $rawFriends[0][ResponseOptions::LAST_NAME],
                $rawFriends[0][ResponseOptions::ID],
                $rawFriends[0][ResponseOptions::AVATAR],
                $rawMutualFriends[0][ResponseOptions::COMMON_COUNT],
            ),
            new Friend(
                $rawFriends[1][ResponseOptions::FIRST_NAME],
                $rawFriends[1][ResponseOptions::LAST_NAME],
                $rawFriends[1][ResponseOptions::ID],
                $rawFriends[1][ResponseOptions::AVATAR],
                $rawMutualFriends[1][ResponseOptions::COMMON_COUNT],
            ),
        ];

        static::assertEquals($expected, $actual);
    }

    public function testBuildFriends_hasInvalidRawArrayFriends_returnFriendArray()
    {
        $rawFriends = [
            [
                ResponseOptions::ID     => $this->faker->randomNumber(),
                ResponseOptions::AVATAR => $this->faker->imageUrl,
            ],
            [
                ResponseOptions::FIRST_NAME => $this->faker->name,
                ResponseOptions::AVATAR     => $this->faker->imageUrl,
            ],
        ];

        $this->expectException(InvalidStructureException::class);

        (new FriendsBuilder)->buildFriends($rawFriends)->getResult();
    }

    public function testBuildCountMutual_hasArrayFriendsIsEmpty_returnEmptyArray()
    {
        $rawMutualFriends = [
            [
                ResponseOptions::ID           => $this->faker->randomDigit(),
                ResponseOptions::COMMON_COUNT => $this->faker->randomDigit(),
            ],
            [
                ResponseOptions::ID           => $this->faker->randomDigit(),
                ResponseOptions::COMMON_COUNT => $this->faker->randomDigit(),
            ],
        ];

        $actual = (new FriendsBuilder)->buildCountMutual($rawMutualFriends)
            ->getResult();

        static::assertEmpty($actual);
    }


}
