<?php


class Person
{
    private $name;
    private $left;
    private $top;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getAll()
    {
        var_dump($this->name);
    }

    public function setPosition($left, $top)
    {
        $this->left = $left;
        $this->top = $top;
    }

    public function getPosition()
    {
        return [$this->left, $this->top];
    }
}