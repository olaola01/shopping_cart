<?php

namespace Src\helper;


class Notification
{
    public function display_success_message()
    {
        $output = '';
        $path = new Path();
        $msg = self::message();
        if(isset($msg) && $msg != '') {
            self::clear_message();
            $output .= '<div class="alert alert-success alert-dismissible" role="alert">';
            $output .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            $output .= '<div class="alert-icon contrast-alert">';
            $output .= '<i class="fa fa-check"></i>';
            $output .= '</div>';
            $output .= '<div class="alert-message">';
            $output .= ' <span><strong>Success! </strong>' . $path->h($msg) . '</span>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }
    }

    public function display_danger_message()
    {
        $output = '';
        $path = new Path();
        $msg = self::message();
        if(isset($msg) && $msg != '') {
            self::clear_message();
            $output .= '<div class="alert alert-danger alert-dismissible" role="alert">';
            $output .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            $output .= '<div class="alert-icon contrast-alert">';
            $output .= '<i class="fa fa-check"></i>';
            $output .= '</div>';
            $output .= '<div class="alert-message">';
            $output .= ' <span><strong>Danger! </strong>' . $path->h($msg) . '</span>';
            $output .= '</div>';
            $output .= '</div>';
            return $output;
        }

    }

    public function message($msg="")
    {
        if (!empty($msg)) {

            $_SESSION['message'] = $msg;
            return true;
        } else {
            return $_SESSION['message'] ?? '';
        }
    }

    protected static function clear_message()
    {
        unset($_SESSION['message']);
    }
}