<?php

namespace WJS\API\Resolvers;

/**
 * @package WJS\API\Resolvers
 */
class ValueEncoder
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public static function encode($value)
    {
        try {
            return to_json($value);
        } catch (\Throwable $err) {
            return $value;
        }
    }
}
