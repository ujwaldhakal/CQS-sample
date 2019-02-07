<?php

namespace Ep\Announcement\Fields;

final class AnnouncementFillables
{
    const ANNOUNCEMENT_FIELDS = [
        'content',
        'title',
        'is_must_read',
    ];


    final public static function getAllowedFields()
    {
        return self::ANNOUNCEMENT_FIELDS;
    }
}
