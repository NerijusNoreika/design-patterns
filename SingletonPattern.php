<?php

class ObjectSingleton
{

    private static ObjectSingleton $singleton;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new Exception('Not possible to unserialize');
    }

    public static function getInstance()
    {
        if (!isset(self::$singleton)) {
            self::$singleton = new ObjectSingleton;
        }

        return self::$singleton;
    }
}
$s1 = ObjectSingleton::getInstance();

$s2 = ObjectSingleton::getInstance();

// $s3 = new ObjectSingleton(); // not possible constructor is private

// $s3 = clone $s2; not possible since __clone is private
// 

// unserialize(serialize($s1)); not possible to unserialize because we throw exception 

echo $s1 === $s2; // is true