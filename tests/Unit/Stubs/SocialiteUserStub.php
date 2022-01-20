<?php

namespace Tests\Unit\Stubs;

use Laravel\Socialite\Contracts\User;

class SocialiteUserStub implements User
{
    public function __construct(
        private string|int $id,
        private string $nickname,
        private string $name,
        private string $email,
        private string $avatar,
        public ?string $token = null,
        public ?int $expiresIn = null,
    ) {
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
}
