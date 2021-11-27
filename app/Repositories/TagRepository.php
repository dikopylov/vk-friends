<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

final class TagRepository
{
    private const TABLE = 'tags_users';

    public function attachToFriend(int $tagId, int $friendId): int
    {
        return DB::table(self::TABLE)->insertOrIgnore(['user_id' => $friendId, 'tag_id' => $tagId]);
    }

    public function detachFromFriend(int $tagId, int $friendId): int
    {
        return DB::table(self::TABLE)->where(['user_id' => $friendId, 'tag_id' => $tagId])->delete();
    }
}
