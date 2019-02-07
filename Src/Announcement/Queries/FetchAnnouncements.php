<?php

namespace Ep\Announcement\Queries;

use Ep\Announcement\Queries\Alias\FetchAnnouncementAlias;
use Ep\Announcement\Queries\Filters\AnnouncementFilter;
use Illuminate\Database\Connection;
use Ep\Util\HasResourceCollection;
use Illuminate\Support\Collection;

class FetchAnnouncements implements HasResourceCollection
{
    private $connection;
    private $filter;
    private $record;
    private $companyId;


    public function __construct(Connection $connection, AnnouncementFilter $filter, $companyId)
    {
        $alias =  new FetchAnnouncementAlias();
        $this->connection = $connection;
        $this->filter = $filter;
        $this->companyId = $companyId;

        $this->record = $this->queryForAnnouncement()->selectRaw($alias->generate($this->filter->getFields()))->get();
    }

    public function get()
    {
        return $this->record->toArray();
    }


    private function queryForAnnouncement()
    {
        $query = $this->connection->table(ANNOUNCEMENT_TABLE);

        if ($this->companyId) {
            $query = $query->where('company_id', $this->companyId);
        }

        return $query;
    }

}
