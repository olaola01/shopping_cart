<?php

namespace Src\helper;


class StringUtils
{

    protected static $database;

    public static function set_database($database)
    {
        self::$database = $database;
    }

    public function format_date()
    {
        return date("Y-m-d:h:i:s");
    }

}