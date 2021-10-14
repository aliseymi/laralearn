<?php

namespace App;

class Container
{
    protected $binding = [];
    public function bind($key,$service)
    {
        $this->binding[$key] = $service;
    }

    public function resolve($key)
    {
        return call_user_func($this->binding[$key]);
    }
}
