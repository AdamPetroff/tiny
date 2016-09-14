<?php

namespace App\Model;

use Nette;

abstract class Base extends Nette\Object
{
    public $database;

    public $table_name = '';

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }

    public function find($id)
    {
        return $this->database->table($this->table_name)->get($id);
    }

    public function insert($entry)
    {
        return $this->database->table($this->table_name)->insert($entry);
    }

    public function update($entry)
    {
        return $this->database->table($this->table_name)->update($entry);
    }
}