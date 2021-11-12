<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;

class CartItem extends DatabaseObject
{

    protected static $table_name = "cart_items";
    protected static $columns = ['product_id', 'quantity', 'user_id', 'created', 'modified'];
 
    // object properties
    public $id;
    public $product_id;
    public $name;
    public $price;
    public $subtotal;
    public $quantity;
    public $user_id;
    public $created;
    public $modified;
 
    // constructor
    public function __construct($args=[])
    {
        $this->product_id = $args['product_id'] ?? '';
        $this->quantity = $args['quantity'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->created = $args['created'] ?? '';
        $this->modified = $args['modified'] ?? '';
    }
}