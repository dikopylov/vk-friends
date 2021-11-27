<?php

declare(strict_types=1);


namespace App\Http\Resources;


use App\Vk\Entities\Friend;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Friend
 */
class MutualFriendResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->getId(),
            'name'   => $this->getFullName(),
            'avatar' => $this->getAvatar(),
        ];
    }
}