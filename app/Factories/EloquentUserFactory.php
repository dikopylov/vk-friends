<?php

declare(strict_types=1);


namespace App\Factories;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class EloquentUserFactory implements UserFactoryInterface
{
    private const MOCK_PASSWORD = 'test';

    /**
     * @param SocialiteUser $socialiteUser
     *
     * @return Authenticatable
     */
    public function make(SocialiteUser $socialiteUser): Authenticatable
    {
        /** @var \Illuminate\Foundation\Auth\User $user */
        $user = $this->getUserClass()::findOrNew($socialiteUser->getId());

        $user->id       = $socialiteUser->getId();
        $user->name     = $socialiteUser->getName();
        $user->email    = $socialiteUser->getEmail();
        $user->avatar   = $socialiteUser->getAvatar();
        $user->nickname = $socialiteUser->getNickname();

        if (! $user->exists) {
            $user->password = Hash::make(static::MOCK_PASSWORD);
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return $user;
    }

    private function getUserClass(): string
    {
        return config('auth.providers.users.model');
    }
}
