<?php

namespace Src\Session;


class UserSession
{
    private $user;

    public function __construct()
    {

    }

    public function get_session_id(){
        return $this->user;
    }

    public function store($user){
        if($user){
            session_regenerate_id();
            $this->user = $_SESSION['user'] = $user->id;
        }
        return true;
    }

}