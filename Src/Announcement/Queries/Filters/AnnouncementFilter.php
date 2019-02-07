<?php

namespace Ep\Announcement\Queries\Filters;


use Carbon\Carbon;
use Illuminate\Support\Collection;

class AnnouncementFilter
{
    private $allowedParams = [
        'fields'
    ];
    private $allowedFields = [
        'content',
        'announcement_id',
        'title'
    ];
    private $fields;
    private $params;

    public function __construct($filters)
    {

        $this->params = new Collection();
        foreach ($filters as $key => $filter) {
            if (\in_array($key, $this->allowedParams)) {

                if ($key === "fields") {
                    $filter = explode(',', $filter);
                }
                $this->params->put($key, $filter);
            }
        }

    }

    private function filterFields()
    {
        if ($this->params->get('fields')) {
            $this->fields = array_intersect($this->allowedFields, $this->params->get('fields'));
            if (empty($this->fields)) {
                throw new NoAnyProcessableFields();
            }
        }
    }

    public function getFields(): array
    {
        $this->filterFields();

        return $this->fields;
    }
}
