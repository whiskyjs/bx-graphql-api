<?php

namespace WJS\API\GraphQL;

use GraphQL\Client as GraphQLClient;
use GraphQL\Results;
use GraphQL\Query as QueryType;

use Machaon\Std\Url;

class Client
{
    /**
     * @var string[]
     */
    private static $requiredOptions = [
        "url",
        "login",
        "password",
    ];

    /**
     * @param string $url
     * @return string
     */
    private static function buildEndpointUrl(string $url): string
    {
        $url = new Url($url);

        return $url->setPath(config("wjs.api.graphql.endpoint"))->toString();
    }

    /**
     * @param string $login
     * @param string $password
     * @return string
     */
    private static function buildAuthorizationString(string $login, string $password): string
    {
        return "Basic " . base64_encode($login . ":" . $password);
    }

    /**
     * @param array $options
     * @return array|\string[][]
     */
    private static function buildHttpOptions(array $options): array
    {
        $headers = [
            "X-Authorization" => static::buildAuthorizationString(
                $options["login"],
                $options["password"]
            ),
        ];

        return array_merge($options["httpOptions"] ?? [], [
            'headers' => array_merge($headers, $options["httpOptions"]["headers"] ?? [])
        ]);
    }

    /**
     * @var string[]
     */
    private $options;

    /**
     * @var GraphQLClient
     */
    private $client;

    /**
     * @param array $options
     * @throws \Exception
     */
    public function __construct(array $options)
    {
        $this->options = $this->checkOptions($options);

        $this->client = new GraphQLClient(
            static::buildEndpointUrl($options["url"]),
            ["Authorization" => static::buildAuthorizationString($options["login"], $options["password"])],
            static::buildHttpOptions($options)
        );
    }

    /**
     * @param array $options
     * @return array
     * @throws \Exception
     */
    private function checkOptions(array $options): array
    {
        foreach (static::$requiredOptions as $name) {
            if (!isset($options[$name])) {
                throw new \Exception(sprintf(
                    "Не указан обязательный параметр: '%s'.",
                    $name
                ));
            }
        }

        return $options;
    }

    /**
     * @param QueryType $query
     * @param array $variables
     * @return Results
     */
    public function executeQuery(QueryType $query, array $variables = []): Results
    {
        return $this->client->runQuery($query, true, $variables);
    }
}
