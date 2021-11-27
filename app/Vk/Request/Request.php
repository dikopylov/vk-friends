<?php

namespace App\Vk\Request;

abstract class Request implements RequestInterface
{
    public function __construct(private string $accessToken)
    {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
