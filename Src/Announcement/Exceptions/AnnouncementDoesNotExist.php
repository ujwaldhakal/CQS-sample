<?php

namespace Ep\Announcement\Exceptions;

use Ep\Services\Exception\ResponseableException;

class AnnouncementDoesNotExist extends \Exception implements ResponseableException
{
    public function getResponseMessage()
    {
        return "The announcement does not exist";
    }
}
