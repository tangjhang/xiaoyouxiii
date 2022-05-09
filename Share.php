<?php


class Share
{
    private static $player = [];

    public function add($id, $name)
    {
        self::$player[$id] = new Person($name);
    }

    public function getPlayer()
    {
        return self::$player;
    }
}