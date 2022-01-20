<?php

namespace Tests\Unit\Vk\Clients;

use App\Vk\Clients\VKClient;
use App\Vk\Clients\VKResponseParser;
use App\Vk\Request\FriendsRequest;
use App\Vk\Request\MutualFriendsRequest;
use App\Vk\Request\UserRequest;
use App\Vk\Response\FriendsResponse;
use App\Vk\Response\ResponseOptions;
use Tests\Unit\UnitTestCase;
use VK\Actions\Friends;
use VK\Actions\Users;
use VK\Client\VKApiClient;

class VKClientTest extends UnitTestCase
{

    public function testGetFriends()
    {
        $token   = $this->faker->text;
        $userId  = $this->faker->randomDigitNotNull;
        $count   = $this->faker->randomDigitNotNull;
        $client  = $this->prophesize(VKApiClient::class);
        $parser  = $this->prophesize(VKResponseParser::class);
        $friends = $this->prophesize(Friends::class);

        $friendsRequest = new FriendsRequest($token);
        $friendsRequest->setUserId($userId);
        $friendsRequest->setCount($count);

        $targetIDs        = [
            $this->faker->randomDigitNotNull(),
            $this->faker->randomDigitNotNull(),
        ];
        $items            = [
            [ResponseOptions::ID => $targetIDs[0]],
            [ResponseOptions::ID => $targetIDs[1]],
        ];
        $rawFriends       = [ResponseOptions::ITEMS => $items];
        $rawMutualFriends = [];

        $mutualFriendsRequest = new MutualFriendsRequest($token);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs($targetIDs);

        $parser->parseUsers($rawFriends)->shouldBeCalled()->willReturn($rawFriends);

        $friends->getMutual($token, $mutualFriendsRequest->toArray())->shouldBeCalled()->willReturn($rawMutualFriends);
        $friends->get($token, $friendsRequest->toArray())->shouldBeCalled()->willReturn($rawFriends);
        $client->friends()->shouldBeCalledTimes(2)->willReturn($friends->reveal());

        $actual   = (new VKClient($client->reveal(), $parser->reveal()))->getFriends($friendsRequest);
        $expected = new FriendsResponse($rawFriends, $rawMutualFriends, $count);

        static::assertEquals($expected, $actual);
    }

    public function testGetRawMutualFriendIDs()
    {
        $client  = $this->prophesize(VKApiClient::class);
        $parser  = $this->prophesize(VKResponseParser::class);
        $friends = $this->prophesize(Friends::class);

        $token            = $this->faker->text;
        $userId           = $this->faker->randomDigitNotNull;
        $targetIDs        = [
            $this->faker->randomDigitNotNull(),
            $this->faker->randomDigitNotNull(),
        ];
        $rawMutualFriends = [];

        $mutualFriendsRequest = new MutualFriendsRequest($token);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs($targetIDs);

        $friends->getMutual($token, $mutualFriendsRequest->toArray())->shouldBeCalled()->willReturn($rawMutualFriends);
        $client->friends()->shouldBeCalled()->willReturn($friends->reveal());

        (new VKClient($client->reveal(), $parser->reveal()))->getRawMutualFriendIDs($mutualFriendsRequest);
    }

    public function testGetRawFriends()
    {
        $client  = $this->prophesize(VKApiClient::class);
        $parser  = $this->prophesize(VKResponseParser::class);
        $friends = $this->prophesize(Friends::class);

        $token            = $this->faker->text;
        $rawFriends = [];

        $friendsRequest = new FriendsRequest($token);

        $friends->get($token, $friendsRequest->toArray())->shouldBeCalled()->willReturn($rawFriends);
        $client->friends()->shouldBeCalled()->willReturn($friends->reveal());

        (new VKClient($client->reveal(), $parser->reveal()))->getRawFriends($friendsRequest);
    }

    public function testGetUsers()
    {
        $client = $this->prophesize(VKApiClient::class);
        $parser = $this->prophesize(VKResponseParser::class);
        $users  = $this->prophesize(Users::class);

        $token    = $this->faker->text;
        $rawUsers = [];

        $userRequest = new UserRequest($token);

        $users->get($token, $userRequest->toArray())->shouldBeCalled()->willReturn($rawUsers);
        $client->users()->shouldBeCalled()->willReturn($users->reveal());

        (new VKClient($client->reveal(), $parser->reveal()))->getUsers($userRequest);
    }

    public function testGetRawUsers()
    {
        $client = $this->prophesize(VKApiClient::class);
        $parser = $this->prophesize(VKResponseParser::class);
        $users  = $this->prophesize(Users::class);

        $token    = $this->faker->text;
        $rawUsers = [];

        $userRequest = new UserRequest($token);

        $users->get($token, $userRequest->toArray())->shouldBeCalled()->willReturn($rawUsers);
        $client->users()->shouldBeCalled()->willReturn($users->reveal());

        (new VKClient($client->reveal(), $parser->reveal()))->getRawUsers($userRequest);
    }

    public function testGetMutualFriendIDs()
    {
        $client  = $this->prophesize(VKApiClient::class);
        $parser  = $this->prophesize(VKResponseParser::class);
        $friends = $this->prophesize(Friends::class);

        $token            = $this->faker->text;
        $userId           = $this->faker->randomDigitNotNull;
        $targetIDs        = [
            $this->faker->randomDigitNotNull(),
            $this->faker->randomDigitNotNull(),
        ];
        $rawMutualFriends = [];

        $mutualFriendsRequest = new MutualFriendsRequest($token);
        $mutualFriendsRequest->setSourceUID($userId);
        $mutualFriendsRequest->setTargetUIDs($targetIDs);

        $friends->getMutual($token, $mutualFriendsRequest->toArray())->shouldBeCalled()->willReturn($rawMutualFriends);
        $client->friends()->shouldBeCalled()->willReturn($friends->reveal());

        (new VKClient($client->reveal(), $parser->reveal()))->getRawMutualFriendIDs($mutualFriendsRequest);
    }
}
