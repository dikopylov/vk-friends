<?php

namespace App\Vk\Request;

final class RequestOptions
{
    public const DEFAULT_PAGINATION_ITEMS = 10;

    public const DEFAULT_FIELDS = ['nickname', 'photo_200_orig'];

    /**
     * идентификатор пользователя, чьи друзья пересекаются с друзьями пользователя с идентификатором target_uid. Если параметр не задан, то считается, что source_uid равен идентификатору текущего пользователя.
     */
    public const SOURCE_UID = 'source_uid';

    /**
     * список идентификаторов пользователей, с которыми необходимо искать общих друзей.
     */
    public const TARGET_UIDS = 'target_uids';

    /**
     * идентификатор пользователя, с которыми необходимо искать общих друзей.
     */
    public const TARGET_UID = 'target_uid';

    /**
     * количество друзей, которое нужно вернуть. (по умолчанию – все общие друзья)
     */
    public const COUNT = 'count';

    /**
     * смещение, необходимое для выборки определенного подмножества друзей.
     */
    public const OFFSET = 'offset';

    public const USERS_ID = 'user_ids';

    /**
     * список дополнительных полей, которые необходимо вернуть.
     * Доступные значения: nickname, domain, sex, bdate, city, country, timezone, photo_50, photo_100, photo_200_orig, has_mobile, contacts, education, online, relation, last_seen, status, can_write_private_message, can_see_all_posts, can_post, universities
     */
    public const FIELDS = 'fields';

    public const ORDER = 'order';
}
