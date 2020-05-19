<?php

namespace WJS\API\GraphQL\Queries;

use GraphQL\Variable;
use WJS\API\Contracts\GraphQL\Query;

abstract class AbstractQuery implements Query
{
    /**
     * @param string $name
     * @return Variable
     */
    protected function buildQueryVariable(string $name): Variable
    {
        return new Variable($name, '[KeyValuePairInputType!]', false, []);
    }
}
