<?php

declare(strict_types=1);


namespace App\Factories;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class EloquentUserFactory implements UserFactoryInterface
{
    private const PASSWORD_LENGTH = 12;

    /**
     * @param Model $user
     *
     * @throws \Throwable
     */
    public function __construct(private Model $user)
    {
    }

    /**
     * @param SocialiteUser $socialiteUser
     *
     * @return Authenticatable
     */
    public function make(SocialiteUser $socialiteUser): Authenticatable
    {
        $user = $this->user->findOrNew($socialiteUser->getId());

        $user->id       = $socialiteUser->getId();
        $user->name     = $socialiteUser->getName();
        $user->email    = $socialiteUser->getEmail();
        $user->avatar   = $socialiteUser->getAvatar();
        $user->nickname = $socialiteUser->getNickname();

        if (! $user->exists) {
            $user->password = Hash::make(Str::random(self::PASSWORD_LENGTH));
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return $user;
    }
}
