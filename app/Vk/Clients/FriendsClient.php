<?php

namespace App\Vk\Clients;

use App\Vk\Request\FriendsRequest;
use App\Vk\Request\MutualFriendsRequest;
use App\Vk\Request\UserRequest;
use App\Vk\Response\FriendsResponse;
use App\Vk\Response\MutualFriendsResponse;
use App\Vk\Response\UserResponse;

interface FriendsClient
{
    public function getFriends(FriendsRequest $friendsRequest): FriendsResponse;

    public function getMutualFriendIDs(MutualFriendsRequest $mutualFriendsRequest): MutualFriendsResponse;

    public function getRawFriends(FriendsRequest $friendsRequest): array;

    public function getRawMutualFriendIDs(MutualFriendsRequest $mutualFriendsRequest): array;

    public function getRawUsers(UserRequest $userRequest): array;

    public function getUsers(UserRequest $userRequest): UserResponse;
}
