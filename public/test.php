<?php

class Model
{
    private $name;

    public function __construct()
    {
        $this->name = 'mark';
    }

    public function getName()
    {
        return $this->name;
    }
}

class User extends Model
{
    public function __construct()
    {
        // parent::__construct();
    }
}

echo (new User())->getName();
