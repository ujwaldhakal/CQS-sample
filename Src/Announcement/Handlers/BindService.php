<?php

namespace Ep\Announcement\Handlers;

use Ep\Announcement\Entities\Announcement;
use Ep\Announcement\Entities\AnnouncementInterface;
use Ep\Announcement\Entities\Comment;
use Ep\Announcement\Entities\CommentInterface;

class BindService
{
    private $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function bind()
    {
        $this->app->bind(AnnouncementInterface::class, function ($app, $params = []) {
            return new Announcement(app(\Illuminate\Database\Connection::class));
        });

    }
}
