<?php

namespace Tests\Unit\Services;

use App\Builders\FriendsBuilder;
use App\Services\CacheService;
use App\Services\FriendsService;
use App\Vk\Clients\FriendsClient;
use App\Vk\Request\FriendsRequest;
use App\Vk\Request\MutualFriendsRequest;
use App\Vk\Request\RequestOptions;
use App\Vk\Request\UserRequest;
use App\Vk\Response\FriendsResponse;
use App\Vk\Response\MutualFriendsResponse;
use App\Vk\Response\ResponseOptions;
use App\Vk\Response\UserResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\Unit\UnitTestCase;

class FriendsServiceTest extends UnitTestCase
{

    public function testGetFriends_hasUserIdAndPage_returnPaginator()
    {
        $userId = $this->faker->randomDigit();
        $page   = $this->faker->randomDigit();

        $cacheService   = $this->prophesize(CacheService::class);
        $friendsClient  = $this->prophesize(FriendsClient::class);
        $friendsBuilder = $this->prophesize(FriendsBuilder::class);

        $accessToken = $this->faker->text;
        $cacheService->getAccessTokenByUserKey($userId)->shouldBeCalled()->willReturn($accessToken);

        $friendsRequest = new FriendsRequest($accessToken);
        $friendsRequest->setUserId($userId);
        $friendsRequest->setPage($page);
        $friendsRequest->setFields(RequestOptions::DEFAULT_FIELDS);
        $friendsRequest->setCount(RequestOptions::DEFAULT_PAGINATION_ITEMS);

        $friendsCount  = $this->faker->randomDigit();
        $rawFriends    = [ResponseOptions::ITEMS => [], ResponseOptions::COUNT => $friendsCount];
        $friends       = [];
        $mutualFriends = [];
        $perPage       = $this->faker->randomDigit();

        $friendsResponse = new FriendsResponse($rawFriends, $mutualFriends, $perPage);

        $friendsClient->getFriends($friendsRequest)->shouldBeCalled()->willReturn($friendsResponse);

        $friendsBuild = [];

        $friendsBuilder->getResult()
            ->shouldBeCalled()
            ->willReturn($friendsBuild);
        $friendsBuilder->buildCountMutual($mutualFriends)
            ->shouldBeCalled()
            ->willReturn($friendsBuilder->reveal());
        $friendsBuilder->buildFriends($friends)
            ->shouldBeCalled()
            ->willReturn($friendsBuilder->reveal());

        $actual = (new FriendsService(
            $cacheService->reveal(),
            $friendsClient->reveal(),
            $friendsBuilder->reveal())
        )
            ->getFriends($userId, $page);

        $expected = new LengthAwarePaginator(
            $friends,
            $friendsCount,
            $perPage
        );

        static::assertEquals($expected, $actual);
    }

    public function testGetMutualFriends_hasMutualFriendsResponseIsNotEmpty_returnPaginator()
    {
        $userId       = $this->faker->randomDigit();
        $mutualUserId = $this->faker->randomDigit();
        $page         = $this->faker->randomDigit();

        $cacheService   = $this->prophesize(CacheService::class);
        $friendsClient  = $this->prophesize(FriendsClient::class);
        $friendsBuilder = $this->prophesize(FriendsBuilder::class);

        $accessToken = $this->faker->text;
        $cacheService->getAccessTokenByUserKey($userId)->shouldBeCalled()->willReturn($accessToken);

        $mutualFriendsRequest = new MutualFriendsRequest($accessToken);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs([$mutualUserId]);
        $mutualFriendsRequest->setPage($page);
        $mutualFriendsRequest->setCount(RequestOptions::DEFAULT_PAGINATION_ITEMS);

        $commonIds             = [
            $this->faker->randomDigitNotNull(),
            $this->faker->randomDigitNotNull(),
        ];
        $countCommon           = $this->faker->randomDigitNotNull;
        $mutualFriends         = [
            [
                ResponseOptions::COMMON_COUNT   => $countCommon,
                ResponseOptions::COMMON_FRIENDS => $commonIds,
            ],
        ];
        $mutualFriendsResponse = new MutualFriendsResponse($mutualFriends);
        $friendsClient->getMutualFriendIDs($mutualFriendsRequest)->shouldBeCalled()->willReturn($mutualFriendsResponse);

        $userRequest = new UserRequest($accessToken);
        $userRequest->setUserIds($commonIds);
        $userRequest->setFields(RequestOptions::DEFAULT_FIELDS);

        $users        = [];
        $userResponse = new UserResponse($users);
        $friendsClient->getUsers($userRequest)->shouldBeCalled()->willReturn($userResponse);

        $friendsBuild = [];

        $friendsBuilder->getResult()
            ->shouldBeCalled()
            ->willReturn($friendsBuild);
        $friendsBuilder->buildFriends($users)
            ->shouldBeCalled()
            ->willReturn($friendsBuilder->reveal());

        $actual = (new FriendsService(
            $cacheService->reveal(),
            $friendsClient->reveal(),
            $friendsBuilder->reveal())
        )
            ->getMutualFriends($userId, $mutualUserId, $page);

        $expected = new LengthAwarePaginator(
            $friendsBuild,
            $countCommon,
            RequestOptions::DEFAULT_PAGINATION_ITEMS
        );

        static::assertEquals($expected, $actual);
    }

    public function testGetMutualFriends_hasMutualFriendsResponseIsEmpty_returnPaginator()
    {
        $userId       = $this->faker->randomDigit();
        $mutualUserId = $this->faker->randomDigit();
        $page         = $this->faker->randomDigit();

        $cacheService   = $this->prophesize(CacheService::class);
        $friendsClient  = $this->prophesize(FriendsClient::class);
        $friendsBuilder = $this->prophesize(FriendsBuilder::class);

        $accessToken = $this->faker->text;
        $cacheService->getAccessTokenByUserKey($userId)->shouldBeCalled()->willReturn($accessToken);

        $mutualFriendsRequest = new MutualFriendsRequest($accessToken);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs([$mutualUserId]);
        $mutualFriendsRequest->setPage($page);
        $mutualFriendsRequest->setCount(RequestOptions::DEFAULT_PAGINATION_ITEMS);

        $commonIds             = [
            $this->faker->randomDigitNotNull(),
            $this->faker->randomDigitNotNull(),
        ];
        $countCommon           = 0;
        $mutualFriends         = [
            [
                ResponseOptions::COMMON_COUNT   => $countCommon,
                ResponseOptions::COMMON_FRIENDS => $commonIds,
            ],
        ];
        $mutualFriendsResponse = new MutualFriendsResponse($mutualFriends);
        $friendsClient->getMutualFriendIDs($mutualFriendsRequest)->shouldBeCalled()->willReturn($mutualFriendsResponse);

        $actual = (new FriendsService(
            $cacheService->reveal(),
            $friendsClient->reveal(),
            $friendsBuilder->reveal())
        )
            ->getMutualFriends($userId, $mutualUserId, $page);

        $expected = new LengthAwarePaginator(
            [],
            $countCommon,
            RequestOptions::DEFAULT_PAGINATION_ITEMS
        );

        static::assertEquals($expected, $actual);
    }
}
