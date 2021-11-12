<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;

class Product extends DatabaseObject
{
 
    // database connection and table name
    protected static $table_name = "products";
    protected static $columns = ['name','price', 'description','modified','created','modified'];
 
    // object properties
    public $id;
    public $name;
    public $price;
    public $description;
    public $created;
    public $modified;
 
    // constructor
    public function __construct($args=[])
    {
        $this->name = $args['name'] ?? '';
        $this->price = $args['price'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->created = $args['created'] ?? '';
        $this->modified = $args['modified'] ?? '';
    }
}