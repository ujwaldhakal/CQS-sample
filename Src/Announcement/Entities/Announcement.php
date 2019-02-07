<?php

namespace Ep\Announcement\Entities;

use Ep\Announcement\Services\AnnouncementCreationService;
use Ep\Announcement\Services\AnnouncementDeletionService;
use Ep\Announcement\Services\AnnouncementUpdateService;
use Ep\Announcement\Services\CommentCreationService;
use Ep\Announcement\Services\CommentDeletionService;
use Ep\Announcement\Services\CommentUpdateService;
use Ep\Services\Database\Query;
use Illuminate\Database\ConnectionInterface;

class Announcement extends Query implements AnnouncementInterface
{
    protected $connection;

    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    public function create(AnnouncementCreationService $service)
    {
        return $this->useDefaultTable()->insert($service->extract());
    }


    protected function useDefaultTable()
    {
        return $this->connection->table($this->getDefaultTableName());
    }

    protected function getDefaultTableName()
    {
        return ANNOUNCEMENT_TABLE;
    }
}
