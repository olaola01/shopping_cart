<?php

namespace Src\models;

use Src\databaseHelper\DatabaseObject;

// 'product image' object
class ProductImage extends DatabaseObject
{
 
    // database connection and table name
    protected static $table_name = "product_images";
    protected static $columns = ['product_id','name','timestamp'];
 
    // object properties
    public $id;
    public $product_id;
    public $name;
    public $timestamp;
 
    // constructor
    public function __construct($args=[])
    {
        $this->product_id = $args['product_id'] ?? '';
        $this->name = $args['name'] ?? '';
        $this->timestamp = time();
    }

    
// read the first product image related to a product
//function readFirst(){
//
//    // select query
//    $query = "SELECT id, product_id, name
//            FROM " . $this->table_name . "
//            WHERE product_id = ?
//            ORDER BY name DESC
//            LIMIT 0, 1";
//
//    // prepare query statement
//    $stmt = $this->conn->prepare( $query );
//
//    // sanitize
//    $this->id=htmlspecialchars(strip_tags($this->id));
//
//    // bind prodcut id variable
//    $stmt->bindParam(1, $this->product_id);
//
//    // execute query
//    $stmt->execute();
//
//    // return values
//    return $stmt;
//}
//
//// read all product image related to a product
//function readByProductId(){
//
//    // select query
//    $query = "SELECT id, product_id, name
//            FROM " . $this->table_name . "
//            WHERE product_id = ?
//            ORDER BY name ASC";
//
//    // prepare query statement
//    $stmt = $this->conn->prepare( $query );
//
//    // sanitize
//    $this->product_id=htmlspecialchars(strip_tags($this->product_id));
//
//    // bind prodcut id variable
//    $stmt->bindParam(1, $this->product_id);
//
//    // execute query
//    $stmt->execute();
//
//    // return values
//    return $stmt;
//}
}