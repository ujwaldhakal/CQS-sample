<?php

namespace Ep\Announcement\Handlers;

use Ep\Announcement\Events\AnnouncementDeleted;
use Ep\Announcement\Events\AnnouncementUpdated;
use Ep\Announcement\Events\CommentCreated;
use Ep\Announcement\Events\CommentDeleted;
use Ep\Announcement\Events\CommentUpdated;
use Ep\Announcement\Listeners\DeleteAnnouncement;
use Ep\Announcement\Listeners\DeleteComment;
use Ep\Announcement\Listeners\Notifications\NotifyOnAnnouncementCreation;
use Ep\Announcement\Listeners\PersistAnnouncement;
use Ep\Announcement\Events\AnnouncementCreated;
use Ep\Announcement\Listeners\PersistComment;
use Ep\Announcement\Listeners\UpdateAnnouncement;
use Ep\Announcement\Listeners\UpdateComment;

class EventService
{
    public static function getRegisteredEvents()
    {
        return [
            AnnouncementCreated::class => [
                PersistAnnouncement::class,
            ]
        ];
    }
}
