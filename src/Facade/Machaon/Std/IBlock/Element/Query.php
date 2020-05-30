<?php

namespace WJS\API\Facade\Machaon\Std\IBlock\Element;

use WJS\API\GraphQL\Client;
use WJS\API\GraphQL\Queries\Factory as QueryFactory;
use WJS\API\GraphQL\Queries\IBlock\Elements as IBlockElements;
use WJS\API\Resolvers\IBlock\Elements\Query as IBlockElementResolver;

/**
 * @package WJS\API\Facade\Machaon\Std\IBlock\Element
 */
class Query
{
    /**
     * @param array $args
     * @return array
     * @throws \Exception
     */
    public static function getList(array $args = []): array
    {
        $clientOptions = $args["endpoint"] ?? config("wjs.api.client.endpoint");

        unset($args["endpoint"]);

        $client = new Client($clientOptions);

        $query = QueryFactory::create(IBlockElements::class);
        $result = $client->executeQuery(
            $query->getQuery(),
            IBlockElementResolver::encodeParams($args)
        );

        $elements = $query->getQueryData($result->getData());

        return IBlockElementResolver::decodeElements($elements);
    }
}
