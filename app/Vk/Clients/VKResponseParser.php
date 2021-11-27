<?php

declare(strict_types=1);


namespace App\Vk\Clients;


use App\Vk\Response\ResponseOptions;
use Illuminate\Support\Arr;

class VKResponseParser
{
    public function parseUsers(array $users): array
    {
        foreach ($users[ResponseOptions::ITEMS] as $key => $rawUser) {
            if (isset($rawUser[ResponseOptions::DEACTIVATED])) {
                Arr::forget($users[ResponseOptions::ITEMS], $key);
            }
        }

        return $users;
    }
}