<?php

namespace Ep\Announcement\Events;

use Ep\Announcement\Services\AnnouncementCreationService;

class AnnouncementCreated
{
    private $service;

    public function __construct(AnnouncementCreationService $announcementCreationService)
    {
        $this->service = $announcementCreationService;
    }

    public function getService(): AnnouncementCreationService
    {
        return $this->service;
    }
}
