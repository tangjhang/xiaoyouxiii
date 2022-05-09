<?php


class Person
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getAll()
    {
        var_dump($this->name);
    }
}