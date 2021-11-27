<?php

namespace App\Services;

use App\Builders\FriendsBuilder;
use App\Vk\Clients\FriendsClient;
use App\Vk\Clients\VKClient;
use App\Vk\Request\FriendsRequest;
use App\Vk\Request\MutualFriendsRequest;
use App\Vk\Request\RequestOptions;
use App\Vk\Request\UserRequest;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FriendsService
{
    public function __construct(
        private CacheService   $cacheService,
        private FriendsClient  $client,
        private FriendsBuilder $builder
    ) {
    }

    public function getFriends(int $userId, int $page): LengthAwarePaginator
    {
        $accessToken = $this->cacheService->getAccessTokenByUserKey($userId);

        $friendsRequest = new FriendsRequest($accessToken);
        $friendsRequest->setUserId($userId);
        $friendsRequest->setPage($page);
        $friendsRequest->setFields(RequestOptions::DEFAULT_FIELDS);
        $friendsRequest->setCount(RequestOptions::DEFAULT_PAGINATION_ITEMS);

        $friendsResponse = $this->client->getFriends($friendsRequest);

        $friends = $this->builder->buildFriends($friendsResponse->getItems())
            ->buildCountMutual($friendsResponse->getMutual())
            ->getResult();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $friends,
            $friendsResponse->getCount(),
            $friendsResponse->getPerPage(),
        );
    }

    public function getMutualFriends(int $userId, int $mutualUserId, int $page): LengthAwarePaginator
    {
        $accessToken = $this->cacheService->getAccessTokenByUserKey($userId);

        $mutualFriendsRequest = new MutualFriendsRequest($accessToken);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs([$mutualUserId]);
        $mutualFriendsRequest->setPage($page);
        $mutualFriendsRequest->setCount(RequestOptions::DEFAULT_PAGINATION_ITEMS);

        $mutualFriendsResponse = $this->client->getMutualFriendIDs($mutualFriendsRequest);

        if ($mutualFriendsResponse->isEmpty()) {
            return new \Illuminate\Pagination\LengthAwarePaginator(
                [],
                $mutualFriendsResponse->getCountCommon(),
                $mutualFriendsRequest->getCount(),
            );
        }

        $userRequest = new UserRequest($accessToken);
        $userRequest->setUserIds($mutualFriendsResponse->getCommonIDs());
        $userRequest->setFields(RequestOptions::DEFAULT_FIELDS);

        $userResponse = $this->client->getUsers($userRequest);

        $friends = $this->builder->buildFriends($userResponse->getUsers())->getResult();

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $friends,
            $mutualFriendsResponse->getCountCommon(),
            $mutualFriendsRequest->getCount(),
        );
    }
}
