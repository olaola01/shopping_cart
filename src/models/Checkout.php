<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;
use Src\Validation\Validator;

// 'cart item' object
class Checkout extends DatabaseObject
{
 
    // database connection and table name
    protected static $table_name = "checkout";
    protected static $columns = ['product_id','order_id','sub_total','total','delivery_type', 'quantity', 'user_id', 'created'];
 
    // object properties
    public $id;
    public $product_id;
    public $order_id;
    public $sub_total;
    public $total;
    public $delivery_type;
    public $quantity;
    public $user_id;
    public $created;
 
    // constructor
    public function __construct($args=[])
    {
        $this->product_id = $args['product_id'] ?? '';
        $this->sub_total = $args['sub_total'] ?? '';
        $this->total = $args['total'] ?? '';
        $this->order_id = $args['order_id'] ?? '';
        $this->delivery_type = $args['delivery_type'] ?? '';
        $this->quantity = $args['quantity'] ?? '';
        $this->user_id = $args['user_id'] ?? '';
        $this->created = time();
    }

    protected function validate()
    {
        $this->errors = [];

        if (Validator::is_blank($this->delivery_type)){
            $this->errors[] = "Delivery field is required";
        }

        return $this->errors;
    }


}