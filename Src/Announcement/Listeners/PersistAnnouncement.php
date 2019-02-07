<?php

namespace Ep\Announcement\Listeners;

use Ep\Announcement\Entities\AnnouncementInterface;
use Ep\Announcement\Events\AnnouncementCreated;

class PersistAnnouncement
{
    private $announcement;

    public function __construct(AnnouncementInterface $announcement)
    {
        $this->announcement = $announcement;
    }

    public function handle(AnnouncementCreated $event)
    {
        $this->announcement->create($event->getService());
    }
}
