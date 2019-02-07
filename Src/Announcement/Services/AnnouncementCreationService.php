<?php

namespace Ep\Announcement\Services;

use Ep\Announcement\Entities\Hr;
use Ep\Services\WriteService\CreateInterface;

class AnnouncementCreationService implements CreateInterface
{
    private $content;
    private $title;
    private $mustRead;
    private $id;
    private $hr;

    public function __construct($content, $title, $mustRead, Hr $hr)
    {
        $this->content = $content;
        $this->title = $title;
        $this->mustRead = $mustRead;
        $this->id = getUuid();
        $this->hr = $hr;
    }

    public function getCompanyId()
    {
        return $this->hr->getCompanyId();
    }

    public function getId()
    {
        return $this->id;
    }

    public function extract()
    {
        return [
            'id' => $this->getId(),
            'content' => $this->content,
            'title' => $this->title,
            'is_must_read' => $this->mustRead,
            'created_by' => $this->hr->getId(),
            'company_id' => $this->getCompanyId(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
