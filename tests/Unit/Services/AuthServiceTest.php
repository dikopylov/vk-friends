<?php

namespace Tests\Unit\Services;

use App\Factories\UserFactoryInterface;
use App\Services\AuthService;
use App\Services\CacheService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Two\User;
use Tests\Unit\Stubs\UserStub;
use Tests\Unit\UnitTestCase;

class AuthServiceTest extends UnitTestCase
{

    public function testLogin_hasSocialiteUser_returnUser()
    {
        $userFactory  = $this->prophesize(UserFactoryInterface::class);
        $cacheService = $this->prophesize(CacheService::class);

        $socialiteUser = new User();
        $user          = new UserStub();

        $userFactory->make($socialiteUser)->shouldBeCalled()->willReturn($user);
        $cacheService->putUser($user, $socialiteUser)->shouldBeCalled();
        Auth::spy();

        $actual   = (new AuthService($userFactory->reveal(), $cacheService->reveal()))->login($socialiteUser);
        $expected = $user;

        self::assertEquals($expected, $actual);
        Auth::shouldHaveReceived('login')->with($user, true);
    }

    public function testLogout_throwException()
    {
        $userFactory  = $this->prophesize(UserFactoryInterface::class);
        $cacheService = $this->prophesize(CacheService::class);

        Auth::partialMock()->expects('logout');

        $this->expectException(AuthenticationException::class);

        (new AuthService($userFactory->reveal(), $cacheService->reveal()))->logout();
    }
}
