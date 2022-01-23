<?php

namespace Tests\Vk\Unit\Clients;

use App\Vk\Clients\VKResponseParser;
use App\Vk\Response\ResponseOptions;
use PHPUnit\Framework\TestCase;
use Tests\Unit\UnitTestCase;

class VKResponseParserTest extends UnitTestCase
{

    public function testParseUsers()
    {
        $activeUserId     = $this->faker->randomDigitNotNull;
        $deactivateUserId = $this->faker->randomDigitNotNull;

        $users = [
            ResponseOptions::ITEMS => [
                [
                    ResponseOptions::ID => $activeUserId,
                ],
                [
                    ResponseOptions::ID          => $deactivateUserId,
                    ResponseOptions::DEACTIVATED => true,
                ],
            ],
        ];

        $actual   = (new VKResponseParser())->parseUsers($users);
        $expected = [
            ResponseOptions::ITEMS => [
                [
                    ResponseOptions::ID => $activeUserId,
                ],
            ],
        ];

        static::assertEquals($expected, $actual);
    }
}
