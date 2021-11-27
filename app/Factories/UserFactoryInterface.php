<?php

namespace App\Factories;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as SocialiteUser;

interface UserFactoryInterface
{
    /**
     * @param SocialiteUser $socialiteUser
     *
     * @return Authenticatable
     */
    public function make(SocialiteUser $socialiteUser): Authenticatable;
}
