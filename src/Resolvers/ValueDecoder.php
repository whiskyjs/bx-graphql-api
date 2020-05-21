<?php

namespace WJS\API\Resolvers;

/**
 * @package WJS\API\Resolvers
 */
class ValueDecoder
{
    /**
     * @param mixed $value
     * @return mixed
     */
    public static function decode($value)
    {
        try {
            return from_json($value);
        } catch (\Throwable $err) {
            return $value;
        }
    }
}
