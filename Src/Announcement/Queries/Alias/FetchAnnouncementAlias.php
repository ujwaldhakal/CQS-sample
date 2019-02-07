<?php

namespace Ep\Announcement\Queries\Alias;

use Ep\Services\Database\Alias\AbstractAlias;

class FetchAnnouncementAlias extends AbstractAlias
{
    protected $alias = [
        'content' => ANNOUNCEMENT_TABLE . '.content',
        'title' => ANNOUNCEMENT_TABLE . '.title',
        'announcement_id' => ANNOUNCEMENT_TABLE . '.id',
    ];

}
