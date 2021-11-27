<?php

namespace App\Vk\Response;

final class ResponseOptions
{
    public const FIRST_NAME = 'first_name';
    public const LAST_NAME  = 'last_name';
    public const ID         = 'id';
    public const AVATAR     = 'photo_200_orig';

    /**
     * количество общих друзей.
     */
    public const COMMON_COUNT = 'common_count';

    public const ITEMS = 'items';

    public const COUNT = 'count';

    /**
     * список общих друзей
     */
    public const COMMON_FRIENDS = 'common_friends';

    public const DEACTIVATED = 'deactivated';

}
