<?php

namespace App\Core;

use PDO;
use BadMethodCallException;

abstract class Model
{
    protected $table;
    protected $fillable;
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->setFetchMode(PDO::FETCH_CLASS, get_class($this));
    }

    public function create($data)
    {
        $fillableData = $this->filterFillableData($data);
        $lastInsertId = $this->db->create($this->table, $fillableData);
        return $this->findById($lastInsertId);
    }

    public function get()
    {
        return $this->db->select($this->table);
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->db->orderBy($column, $direction);
        return $this;
    }

    public function paginate($perPage)
    {
        $this->db->paginate($perPage);
        return $this;
    }

    public function findById($id)
    {
        return $this->db->findById($this->table, $id);
    }

    protected function filterFillableData($data)
    {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    public function update($id,$data)
    {
        return $this->db->update($this->table,$data,"id=$id");
    }

    public function delete($id)
    {
        return $this->db->delete($this->table,"id=$id");
    }
}

