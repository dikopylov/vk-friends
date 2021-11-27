<?php

declare(strict_types=1);


namespace App\Services;


use App\Models\Tag;
use App\Repositories\TagRepository;

class TagService
{
    public function __construct(private TagRepository $repository)
    {
    }

    public function createTag(string $title): Tag
    {
        return Tag::create(['title' => $title]);
    }

    public function attachTagToFriend(int $tagId, int $friendId): int
    {
        return $this->repository->attachToFriend($tagId, $friendId);
    }

    public function detachFromFriend(int $tagId, int $friendId): int
    {
        return $this->repository->detachFromFriend($tagId, $friendId);
    }
}
