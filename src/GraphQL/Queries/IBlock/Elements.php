<?php

namespace WJS\API\GraphQL\Queries\IBlock;

use GraphQL\Query as QueryType;

use GraphQL\Variable;
use WJS\API\GraphQL\Queries\AbstractQuery;

/**
 * @package WJS\API\GraphQL\Queries\IBlock
 */
class Elements extends AbstractQuery
{
    /**
     * @var string[]
     */
    private static $arguments = [
        "order",
        "filter",
        "page",
        "select",
        "options",
    ];

    /**
     * @return QueryType
     */
    public function getQuery(): QueryType
    {
        return (new QueryType("iblock"))
            ->setVariables(array_map(function ($name) {
                return $this->buildQueryVariable($name);
            }, static::$arguments))
            ->setSelectionSet([
                (new QueryType('elements'))
                    ->setArguments(array_reduce(static::$arguments, function ($acc, $name) {
                        return array_merge($acc, [
                            $name => '$' . $name,
                        ]);
                    }, []))
                    ->setSelectionSet([
                        (new QueryType("fields"))
                            ->setSelectionSet([
                                "CODE",
                                "VALUE",
                            ]),
                        (new QueryType("properties"))
                            ->setSelectionSet([
                                "ID",
                                "CODE",
                                "PROPERTY_TYPE",
                                "USER_TYPE",
                                "MULTIPLE",
                                "VALUE",
                                "DESCRIPTION",
                            ]),
                    ])
            ]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function getQueryData(array $data): array
    {
        return $data["iblock"]["elements"] ?? [];
    }

    /**
     * @param string $name
     * @return Variable
     */
    protected function buildQueryVariable(string $name): Variable
    {
        switch ($name) {
            case "page":
                return new Variable($name, "IBlockElementPageFilterInputType", false);
            case "options":
                return new Variable($name, "IBlockElementOptionsFilterInputType", false);
        }

        return parent::buildQueryVariable($name);
    }
}
