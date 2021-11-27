<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Two\User as SocialiteUser;

class CacheService
{
    private const ACCESS_TOKEN = 'access_token_';

    public function getAccessTokenByUserKey(int $userKey): ?string
    {
        return Cache::get($this->getAccessTokenKey($userKey));
    }

    /**
     * @param Authenticatable $user
     * @param SocialiteUser   $socialiteUser
     */
    public function putUser(Authenticatable $user, SocialiteUser $socialiteUser): void
    {
        Cache::put($this->getAccessTokenKey($user), $socialiteUser->token, $socialiteUser->expiresIn);
    }

    public function hasAccessToken(Authenticatable $user): bool
    {
        return Cache::has($this->getAccessTokenKey($user));
    }

    /**
     * @param Authenticatable|int $user
     *
     * @return string
     */
    private function getAccessTokenKey(Authenticatable|int $user): string
    {
        $key = $user instanceof Authenticatable ? $user->getAuthIdentifier() : $user;

        return self::ACCESS_TOKEN . $key;
    }
}
