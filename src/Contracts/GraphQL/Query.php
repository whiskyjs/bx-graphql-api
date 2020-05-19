<?php

namespace WJS\API\Contracts\GraphQL;

use GraphQL\Query as QueryType;

/**
 * @package WJS\API\Contracts\GraphQL
 */
interface Query
{
    /**
     * @return QueryType
     */
    public function getQuery(): QueryType;

    /**
     * @param array $data
     * @return array
     */
    public function getQueryData(array $data): array;
}
