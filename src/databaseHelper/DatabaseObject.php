<?php

namespace Src\databaseHelper;

use PDO;

class DatabaseObject
{
   static protected $database;
   static protected $table_name = "";
   static protected $columns = [];
   public $errors = [];

    public function set_database($database)
    {
        self::$database = $database;
    }

    public function find_by_sql($sql)
    {
        $stmt = self::$database->prepare($sql);
        if (!$stmt->execute()){
            exit("Database query failed");
        }

        $object_array = [];
        while ($records = $stmt->fetch(\PDO::FETCH_ASSOC)){
            $object_array[] = $this->instantiate($records);
        }

        $stmt->closeCursor();
        return $object_array;
    }

    public function find_by_id($id)
    {
        $sql = "SELECT * FROM " . static::$table_name ." WHERE id='" . $id . "'";
        $stmt = self::find_by_sql($sql);
        if (!empty($stmt)){
            return array_shift($stmt);
        }else{
            return false;
        }
    }

    public function find_product_image_by_id($id)
    {
        $sql = "SELECT * FROM " . static::$table_name ." WHERE product_id='" . $id . "'";
        $stmt = self::find_by_sql($sql);
        if (!empty($stmt)){
            return array_shift($stmt);
        }else{
            return false;
        }
    }

    public function count_all()
    {
        $sql = "SELECT * FROM " . static::$table_name;
        $stmt = self::$database->query($sql);
        $count = $stmt->rowCount();

        return $count;
    }

    public function find_all()
    {
        $sql = "SELECT * FROM " . static::$table_name;
        return self::find_by_sql($sql);
    }

    public function find_all_by_id($id)
    {
        $sql = "SELECT * FROM " . static::$table_name . " WHERE id='" . $id . "' ORDER BY id DESC";
        return self::find_by_sql($sql);
    }

    public function find_all_limit($limit = "")
    {
        $sql = "SELECT * FROM " . static::$table_name ." LIMIT $limit";
        return self::find_by_sql($sql);
    }

    public function find_all_by_order()
    {
        $sql = "SELECT * FROM " . static::$table_name ." ORDER BY id ASC LIMIT 7";
        return self::find_by_sql($sql);
    }

    public function create()
    {
        $this->validate();
        if (!empty($this->errors)) return false;
        $attribute = $this->attributes();
        $columns = implode(',', array_keys($attribute));
        $values = ':'.implode(', :',array_keys($attribute));
        $sql = "INSERT INTO ". static::$table_name. "({$columns}) VALUES ({$values})";
        $stmt = self::$database->prepare($sql);
        if ($stmt){
            foreach ($attribute as $key => $value){
                $stmt->bindValue(':'.$key,$value);

            }
            $stmt->execute();
            $this->id = self::$database->lastInsertId();
        }
        return $stmt;
    }

    public function update($id)
    {
        $this->validate();
        if (!empty($this->errors)) return false;
        $attributes = $this->attributes();
        $attribute_pairs = [];
        foreach ($attributes as $key => $value){
            $attribute_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$table_name . " SET " . join(', ',$attribute_pairs) . " WHERE id='" . $id . "' ";

        $stmt = self::$database->prepare($sql);
        if ($stmt){
            foreach ($attributes as $key => $value){
                $stmt->bindValue(':'.$key,$value);
            }
            $stmt->execute();
        }
        return $stmt;
    }

    public function save()
    {
        // A new record will not have an ID yet
        if(isset($this->id)) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    public function saveRating()
    {



    }

    private function instantiate($records)
    {
        $object = new static();
        foreach ($records as $property => $value){
            if (property_exists($object,$property)){
                $object->$property = $value;
            }
        }
        return $object;
    }

    protected function attributes()
    {
        $attributes = [];
        foreach (static::$columns as $column){
            if ($column == 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    public function merge_attributes($args=[])
    {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    protected function validate()
    {
        $this->errors = [];

        //ADD CUSTOM VALIDATION

        return $this->errors;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . static::$table_name . " WHERE id='" . $id . "' LIMIT 1";
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function exists($product_id)
    {
        $sql = "SELECT count(*) FROM " . static::$table_name . " WHERE product_id=$product_id AND user_id= 1";
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }


    public function getProductCart()
    {
        $sql ="SELECT p.id as product_id, ci.user_id as user_id, ci.id as id, p.name as name, p.price as price, ci.quantity as quantity, ci.quantity * p.price AS subtotal
            FROM " . static::$table_name . " ci
                LEFT JOIN products p
                    ON ci.product_id = p.id
            WHERE ci.user_id= 1 AND ci.product_id != 0";
        return self::find_by_sql($sql);
    }

    public function countCartItems()
        {
        $sql = "SELECT count(*) FROM " . static::$table_name . " WHERE user_id = 1";
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }


    public function get_rating_by_id($product_id)
    {
        $sql =  "SELECT * FROM ". static::$table_name . " WHERE productId = $product_id";

        return self::find_by_sql($sql);
    }

    public function get_average_rating($product_id)
    {
        $sql = "SELECT AVG(ratingNumber) FROM ". static::$table_name. " WHERE  productId = $product_id";
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }

    public function get_average_rating_count($product_id)
    {
        $sql = "SELECT count(*) FROM ". static::$table_name. " WHERE  productId = $product_id";
        $stmt = self::$database->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetch(PDO::FETCH_NUM);
        return $rows[0];
    }

}