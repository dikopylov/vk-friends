<?php

namespace App\Vk\Request;

interface RequestInterface
{
    public function getAccessToken(): string;

    public function toArray(): array;
}
