<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;

class Users extends DatabaseObject

{
      // database connection and table name
    protected static $table_name = "users";
    protected static $columns = ['balance','previous_balance', 'created','modified'];
 
    // object properties
    public $id;
    public $balance;
    public $previous_balance;
    public $created;
    public $modified;
 
    // constructor
    public function __construct($args=[])
    {
        $this->previous_balance = $args['previous_balance'] ?? '';
        $this->balance = $args['balance'] ?? '';
        $this->modified = $args['modified'] ?? '';
    }
}