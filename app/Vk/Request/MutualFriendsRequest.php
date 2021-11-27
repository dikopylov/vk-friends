<?php

namespace App\Vk\Request;

use App\Vk\Request\RequestOptions;

class MutualFriendsRequest extends AbstractFriendsRequest
{
    private ?int $sourceUID = null;

    private ?int   $targetUID  = null;
    private ?array $targetUIDs = null;


    /**
     * @param int $sourceUID
     */
    public function setSourceUID(int $sourceUID): void
    {
        $this->sourceUID = $sourceUID;
    }

    /**
     * @param array $targetUIDs
     */
    public function setTargetUIDs(array $targetUIDs): void
    {
        $this->targetUIDs = $targetUIDs;
    }

    /**
     * @return int|null
     */
    public function getTargetUID(): ?int
    {
        return $this->targetUID;
    }

    /**
     * @param int $targetUID
     */
    public function setTargetUID(int $targetUID): void
    {
        $this->targetUID = $targetUID;
    }

    public function doNotMutualFriends()
    {
        $this->count = 0;
    }

    public function toArray(): array
    {
        $result = [];

        if ($this->sourceUID) {
            $result[RequestOptions::SOURCE_UID] = $this->sourceUID;
        }

        if ($this->targetUID) {
            $result[RequestOptions::TARGET_UID] = $this->targetUID;
        }

        if ($this->targetUIDs) {
            $result[RequestOptions::TARGET_UIDS] = $this->targetUIDs;
        }

        if ($this->count) {
            $result[RequestOptions::COUNT] = $this->count;
        }

        if ($this->offset) {
            $result[RequestOptions::OFFSET] = $this->offset;
        }


        return $result;
    }
}
