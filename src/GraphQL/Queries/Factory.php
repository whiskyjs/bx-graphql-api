<?php

namespace WJS\API\GraphQL\Queries;

use WJS\API\Contracts\GraphQL\Query;

/**
 * @package WJS\API\GraphQL\Queries
 */
class Factory
{
    /**
     * @param string $klass
     * @return Query
     */
    public static function create(string $klass): Query
    {
        return new $klass();
    }
}
