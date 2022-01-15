<?php

namespace Tests\Unit\Factories;

use App\Factories\EloquentUserFactory;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\Unit\Stubs\SocialiteUserStub;
use Tests\Unit\UnitTestCase;

class EloquentUserFactoryTest extends UnitTestCase
{

    public function testMake_hasNotUser_returnUser()
    {
        $auth = $this->prophesize(Model::class);

        $socialiteUser = new SocialiteUserStub(
            $this->faker->randomDigitNotNull(),
            $this->faker->userName(),
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->imageUrl(),
        );

        $actual = (new EloquentUserFactory($auth->reveal()))->make($socialiteUser);

        $expected = new User();
        $expected->id       = $socialiteUser->getId();
        $expected->name     = $socialiteUser->getName();
        $expected->email    = $socialiteUser->getEmail();
        $expected->avatar   = $socialiteUser->getAvatar();
        $expected->nickname = $socialiteUser->getNickname();
        $expected->password = false;
    }
}
