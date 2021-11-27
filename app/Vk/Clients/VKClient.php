<?php

namespace App\Vk\Clients;

use App\Builders\FriendsBuilder;
use App\Vk\Request\FriendsRequest;
use App\Vk\Request\MutualFriendsRequest;
use App\Vk\Request\UserRequest;
use App\Vk\Response\FriendsResponse;
use App\Vk\Response\MutualFriendsResponse;
use App\Vk\Response\ResponseOptions;
use App\Vk\Response\UserResponse;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use VK\Client\VKApiClient;

class VKClient implements FriendsClient
{
    public function __construct(private VKApiClient $client, private VKResponseParser $parser)
    {
    }

    public function getFriends(FriendsRequest $friendsRequestParameters): FriendsResponse
    {
        $rawFriends = $this->parser->parseUsers($this->getRawFriends($friendsRequestParameters));

        $targetIDs  = collect($rawFriends[ResponseOptions::ITEMS])
            ->pluck('id')
            ->toArray();

        $mutualFriendsRequest = new MutualFriendsRequest($friendsRequestParameters->getAccessToken());
        $mutualFriendsRequest->setSourceUID($friendsRequestParameters->getUserId());
        $mutualFriendsRequest->setTargetUIDs($targetIDs);

        $rawMutualFriends = $this->getRawMutualFriendIDs($mutualFriendsRequest);

        return new FriendsResponse($rawFriends, $rawMutualFriends, $friendsRequestParameters->getCount());
    }

    public function getMutualFriendIDs(MutualFriendsRequest $mutualFriendsRequest): MutualFriendsResponse {
        return new MutualFriendsResponse($this->getRawMutualFriendIDs($mutualFriendsRequest));
    }

    public function getRawFriends(FriendsRequest $friendsRequestParameters): array
    {
        return $this->client->friends()->get(
            $friendsRequestParameters->getAccessToken(),
            $friendsRequestParameters->toArray() + ['order' => 'name']
        );
    }

    public function getRawMutualFriendIDs(MutualFriendsRequest $mutualFriendsRequest): array
    {
        return $this->client->friends()->getMutual(
            $mutualFriendsRequest->getAccessToken(),
            $mutualFriendsRequest->toArray()
        );
    }

    public function getRawUsers(UserRequest $userRequest): array
    {
        return $this->client->users()->get($userRequest->getAccessToken(), $userRequest->toArray());
    }

    public function getUsers(UserRequest $userRequest): UserResponse
    {
        $rawUsers = $this->getRawUsers($userRequest);

        return new UserResponse($rawUsers);
    }
}
