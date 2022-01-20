<?php

namespace Tests\Unit\Services;

use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Two\User;
use Tests\Unit\Stubs\UserStub;
use Tests\Unit\UnitTestCase;

class CacheServiceTest extends UnitTestCase
{
    public function testGetAccessTokenByUserKey_hasUserKey_shouldBeCalledGetMethod()
    {
        $userKey = $this->faker()->randomDigit();

        Cache::shouldReceive('get')
            ->with("access_token_{$userKey}")
            ->andReturn($this->faker()->randomDigit());

        (new CacheService())->getAccessTokenByUserKey($userKey);
    }

    public function testPutUser_hasUsers_shouldBeCalledPutMethod()
    {
        $userKey   = $this->faker()->randomDigit();
        $id        = $this->faker->randomDigitNotNull();
        $nickname  = $this->faker->userName();
        $name      = $this->faker->name();
        $email     = $this->faker->email();
        $avatar    = $this->faker->imageUrl();
        $token     = $this->faker()->text;
        $expiresIn = $this->faker()->randomDigit();

        $user     = new UserStub();
        $user->id = $userKey;

        $socialiteUser            = new User();
        $socialiteUser->id        = $id;
        $socialiteUser->nickname  = $nickname;
        $socialiteUser->name      = $name;
        $socialiteUser->email     = $email;
        $socialiteUser->avatar    = $avatar;
        $socialiteUser->token     = $token;
        $socialiteUser->expiresIn = $expiresIn;

        Cache::shouldReceive('put')
            ->with("access_token_{$userKey}", $token, $expiresIn);

        (new CacheService())->putUser($user, $socialiteUser);
    }

    public function testHasUser_hasUser_shouldBeCalledHasMethod()
    {
        $userKey   = $this->faker()->randomDigit();

        $user     = new UserStub();
        $user->id = $userKey;

        Cache::shouldReceive('has')
            ->with("access_token_{$userKey}")
            ->andReturnTrue();

        (new CacheService())->hasAccessToken($user);
    }
}
