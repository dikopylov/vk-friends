<?php

declare(strict_types=1);


namespace App\Services;


use App\Factories\UserFactoryInterface;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Two\User as SocialiteUser;

class AuthService
{

    public function __construct(private UserFactoryInterface $userFactory, private CacheService $cacheService)
    {
    }

    public function auth(SocialiteUser $socialiteUser): ?Authenticatable
    {
        $user = $this->userFactory->make($socialiteUser);

        $this->cacheService->putUser($user, $socialiteUser);

        Auth::login($user, true);

        return $user;
    }

    /**
     * @throws AuthenticationException
     */
    public function logout(): void
    {
        Auth::logout();

        throw new AuthenticationException(
            'Unauthenticated.', redirectTo: route('login')
        );
    }
}
