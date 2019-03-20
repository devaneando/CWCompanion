<?php

namespace App\Traits;

trait ConstantValidationTrait
{
    /**
     * Get a ReflectionClass instante of the class where this trait is used.
     *
     * @return \ReflectionClass
     */
    private static function getReflectionClass()
    {
        return new \ReflectionClass(__CLASS__);
    }

    /**
     * Get all the constants of the class where this trait is used.
     *
     * @return array
     */
    private static function getReflectionClassConstants()
    {
        $reflection = self::getReflectionClass();

        return $reflection->getConstants();
    }

    /**
     * Get all the constants' names of the class where this trait is used.
     *
     * @return array
     */
    private static function getReflectionClassConstantKeys()
    {
        $constants = self::getReflectionClassConstants();
        $keys = array_keys($constants);

        return $keys;
    }

    /**
     * Get all class constants that match a given regex pattern.
     *
     * @param string $regex If you want filter constants by
     *
     * @return array
     */
    public static function getConstantsByRegex(string $regex = '/^.*$/'): array
    {
        $constants = self::getReflectionClassConstants();
        $keys = self::getReflectionClassConstantKeys();
        $values = [];
        foreach ($keys as $key) {
            if (true !== empty(preg_match($regex, $key))) {
                $values[] = $constants[$key];
            }
        }

        return $values;
    }

    /**
     * Checks if a constant value is valid.
     *
     * @param mixed $constant
     * @param string $regex If you want filter constants by
     *
     * @return bool
     */
    private static function isValidConstant($constant, string $regex = '/^.*$/')
    {
        $constants = self::getConstantsByRegex($regex);

        return in_array($constant, $constants);
    }
}
