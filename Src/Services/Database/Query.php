<?php

namespace Ep\Services\Database;

use Illuminate\Database\Connection;
use Illuminate\Support\Collection;

abstract class Query
{
    protected $connection;
    protected $collection;
    protected $query;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findbyId($id)
    {
        $this->query = $this->useDefaultTable()->where($this->getDefaultTableName() . '.id', $id);

        if (!$this->query->first()) {
            return false;
        }

        $this->fill((array)$this->query->first());

        return $this;

    }

    protected function fill($data)
    {
        $this->collection = new Collection($data);
        return $this->collection;
    }



    public function getCompanyId()
    {
        return $this->collection->get('company_id');
    }

    public function getId()
    {
        return $this->collection->get('id');
    }

}
