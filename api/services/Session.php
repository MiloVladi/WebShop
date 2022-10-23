<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function exists($key)
    {
        return isset($_SESSION[$key]);
    }

    public function read($key) {

        if($this->exists($key)) {

            return $_SESSION[$key];
        } else {

            return false;
        }
    }

    public function write($key, $value){
        $_SESSION[$key] = $value;
    }
}