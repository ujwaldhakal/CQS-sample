<?php

namespace Ep\Announcement\Exceptions;

use Ep\Services\Exception\ResponseableException;

class AnnouncementDoesNotBelongToCompany extends \Exception implements ResponseableException
{
    public function getResponseMessage()
    {
        return "Announcement does not belong to this company";
    }
}
