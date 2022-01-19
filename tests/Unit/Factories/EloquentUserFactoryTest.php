<?php

namespace Tests\Unit\Factories;

use App\Factories\EloquentUserFactory;
use Illuminate\Support\Facades\Hash;
use Tests\Unit\Stubs\SocialiteUserStub;
use Tests\Unit\Stubs\UserStub;
use Tests\Unit\UnitTestCase;

class EloquentUserFactoryTest extends UnitTestCase
{

    public function testMake_hasNotUser_returnNewUser()
    {
        $userRepository = $this->prophesize(UserStub::class);
        $user           = $this->prophesize(UserStub::class);

        $id       = $this->faker->randomDigitNotNull();
        $nickname = $this->faker->userName();
        $name     = $this->faker->name();
        $email    = $this->faker->email();
        $avatar   = $this->faker->imageUrl();
        $password = $this->faker->password();

        $socialiteUser = new SocialiteUserStub(
            $id,
            $nickname,
            $name,
            $email,
            $avatar,
        );


        Hash::partialMock()->expects('make')->andReturns($password);

        $user->setAttribute('id', $id)->shouldBeCalled();
        $user->setAttribute('nickname', $nickname)->shouldBeCalled();
        $user->setAttribute('name', $name)->shouldBeCalled();
        $user->setAttribute('email', $email)->shouldBeCalled();
        $user->setAttribute('avatar', $avatar)->shouldBeCalled();
        $user->exists = false;
        $user->setAttribute('password', $password)->shouldBeCalled();
        $user->isDirty()->shouldBeCalled()->willReturn(true);
        $user->save()->shouldBeCalled()->willReturn(true);

        $userRepository->findOrNew($id)->shouldBeCalled()->willReturn($user->reveal());

        (new EloquentUserFactory($userRepository->reveal()))->make($socialiteUser);
    }

    public function testMake_hasUser_returnExistsUser()
    {
        $userRepository = $this->prophesize(UserStub::class);
        $user           = $this->prophesize(UserStub::class);

        $id       = $this->faker->randomDigitNotNull();
        $nickname = $this->faker->userName();
        $name     = $this->faker->name();
        $email    = $this->faker->email();
        $avatar   = $this->faker->imageUrl();
        $password = $this->faker->password();

        $socialiteUser = new SocialiteUserStub(
            $id,
            $nickname,
            $name,
            $email,
            $avatar,
        );


        Hash::partialMock()->expects('make')->never();

        $user->setAttribute('id', $id)->shouldBeCalled();
        $user->setAttribute('nickname', $nickname)->shouldBeCalled();
        $user->setAttribute('name', $name)->shouldBeCalled();
        $user->setAttribute('email', $email)->shouldBeCalled();
        $user->setAttribute('avatar', $avatar)->shouldBeCalled();
        $user->exists = true;
        $user->setAttribute('password', $password)->shouldNotBeCalled();
        $user->isDirty()->shouldBeCalled()->willReturn(false);
        $user->save()->shouldNotBeCalled();

        $userRepository->findOrNew($id)->shouldBeCalled()->willReturn($user->reveal());

        (new EloquentUserFactory($userRepository->reveal()))->make($socialiteUser);
    }

    public function testMake_hasModifiedUser_returnExistsUser()
    {
        $userRepository = $this->prophesize(UserStub::class);
        $user           = $this->prophesize(UserStub::class);

        $id       = $this->faker->randomDigitNotNull();
        $nickname = $this->faker->userName();
        $name     = $this->faker->name();
        $email    = $this->faker->email();
        $avatar   = $this->faker->imageUrl();
        $password = $this->faker->password();

        $socialiteUser = new SocialiteUserStub(
            $id,
            $nickname,
            $name,
            $email,
            $avatar,
        );


        Hash::partialMock()->expects('make')->never();

        $user->setAttribute('id', $id)->shouldBeCalled();
        $user->setAttribute('nickname', $nickname)->shouldBeCalled();
        $user->setAttribute('name', $name)->shouldBeCalled();
        $user->setAttribute('email', $email)->shouldBeCalled();
        $user->setAttribute('avatar', $avatar)->shouldBeCalled();
        $user->exists = true;
        $user->setAttribute('password', $password)->shouldNotBeCalled();
        $user->isDirty()->shouldBeCalled()->willReturn(true);
        $user->save()->shouldBeCalled()->willReturn(true);

        $userRepository->findOrNew($id)->shouldBeCalled()->willReturn($user->reveal());

        (new EloquentUserFactory($userRepository->reveal()))->make($socialiteUser);
    }
}
