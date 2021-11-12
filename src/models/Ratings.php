<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;

class Ratings extends DatabaseObject

{
      // database connection and table name
    protected static $table_name = "item_rating";
    protected static $columns = ['ratingId','productId','userId','ratingNumber', 'created','modified'];
 
    // object properties
    public $ratingId;
    public $productId;
    public $userId;
    public $ratingNumber;
    public $created;
    public $modified;
    public $count;
    public $score;
    
    // constructor
    public function __construct($args=[])
    {
        $this->ratingId = $args['ratingId'] ?? '';
        $this->productId = $args['productId'] ?? '';
        $this->userId = $args['userId'] ?? '';
        $this->ratingNumber = $args['ratingNumber'] ?? '';
        $this->created = $args['created'] ?? '';
    }
}