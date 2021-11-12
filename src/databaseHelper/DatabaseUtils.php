<?php

namespace Src\databaseHelper;


Class DatabaseUtils
{
    protected static $server_name = "mysql:host=localhost; dbname=shopping_app";
    protected static $database_user = "root";
    protected static $database_pass = "";


    public static function database_connection(){
        $connection = new \PDO(self::$server_name,self::$database_user,self::$database_pass);
        $connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES,false);

        return $connection;
    }
}