<?php

namespace WJS\API\GraphQL;

use Bitrix\Main\Config\Option;
use Machaon\Std\Base\Singleton;

use GraphQL\GraphQL;
use GraphQL\Type\Schema;

use WJS\API\GraphQL\Schema\Builder;
use WJS\API\MetaInfo;

class Server extends Singleton
{
    /**
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     */
    protected function authorizeRequest(): void
    {
        global $USER;

        /**
         * @var \CUser $USER
         */

        if (!$USER->IsAdmin() && Option::get(MetaInfo::getInstance()->getModuleName(), "enabled") !== "Y") {
            header('Cache-Control: no-cache, must-revalidate, max-age=0');

            $login = server()->get("PHP_AUTH_USER");
            $password = server()->get("PHP_AUTH_PW");

            $providedCredentials = !(empty($login) && !empty($password));

            if ($providedCredentials) {
                $result = $USER->Login($login, $password);

                if (($result === true) && $USER->IsAdmin()) {
                    $canAccess = true;
                }
            }

            if (!isset($canAccess) || !$canAccess) {
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Authorization Required"');
                echo "¯\_(ツ)_/¯";
                die(401);
            }
        }
    }

    /**
     * @throws \Bitrix\Main\ArgumentNullException
     * @throws \Bitrix\Main\ArgumentOutOfRangeException
     * @throws \JsonException
     */
    public function handleRequest(): void
    {
        // $this->authorizeRequest();

        $schema = new Schema(Builder::getInstance()->getSchema());

        $rawInput = file_get_contents('php://input');

        $input = json_decode($rawInput, true);
        $query = $input['query'];
        $variableValues = $input['variables'] ?? null;

        try {
            $rootValue = [];
            $result = GraphQL::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (\Throwable $e) {
            $output = [
                'errors' => [
                    [
                        "message" => $e->getMessage()
                    ]
                ]
            ];
        }

        header('Content-Type: application/json');

        /** @noinspection PhpUnhandledExceptionInspection */
        die(to_json($output));
    }
}
