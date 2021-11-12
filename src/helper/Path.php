<?php

namespace Src\helper;


class Path
{
    public function url_for($script_path)
    {

        if($script_path[0] != '/') {
            $script_path = "/" . $script_path;
        }
        return WWW_ROOT . $script_path;
    }

    public function is_post_request()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function h($string="") {
        return htmlspecialchars($string);
    }

    public function redirect_to($location)
    {
        header("Location: " . $location);
        exit;
    }

}