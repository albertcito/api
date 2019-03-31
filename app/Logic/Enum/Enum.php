<?php

namespace App\Logic\Enum;

abstract class Enum
{
    private static $constCacheArray = null;
    private static $defaultKey = "_DEFAULT";

    private static function getConstants()
    {
        if (self::$constCacheArray == null) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new \ReflectionClass($calledClass);
            $constants = $reflect->getConstants();
            unset($constants["_DEFAULT"]);
            self::$constCacheArray[$calledClass] = $constants;
        }
        return self::$constCacheArray[$calledClass];
    }

    public static function getArray()
    {
        $constants = self::getConstants();
        return array_values($constants);
    }

    public static function getList()
    {
        $array = self::getArray();
        return implode(', ', $array);
    }

    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();
        if ($strict) {
            return array_key_exists($name, $constants);
        }
        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }
}
