<?php

namespace WJS\API\GraphQL\Schema\Types;

use Bitrix\Main\Type\DateTime;
use WJS\API\Entities\SubscriberTable;
use WJS\API\GraphQL\Schema\Type;

class MutationType extends ExtensibleObjectType
{
    /**
     * @return array|callable
     */
    protected static function getDefaultFields()
    {
        return function () {
            return [
                "inspectEventsSubscribe" => [
                    "type" => Type::string(),
                    "args" => [
                        [
                            "name" => "clientId",
                            "type" => Type::nonNull(Type::string()),
                        ],
                        [
                            "name" => "events",
                            "type" => Type::nonNull(Type::getInstance(ModuleEventSetTypeInput::class)),
                        ],
                    ],
                    "resolve" => function (array $data, array $args = [], ?array $context = null): string {
                        // Актуализируем запись конкретного клиента
                        if ($clientRow = SubscriberTable::getByPrimary($args["clientId"])->fetch()) {
                            $result = SubscriberTable::update($clientRow["UUID"], [
                                "EVENTS" => $args["events"],
                                "UPDATED_AT" => new DateTime(),
                            ]);
                        } else {
                            $result = SubscriberTable::add([
                                "UUID" => $args["clientId"],
                                "EVENTS" => $args["events"],
                            ]);
                        }

                        // TODO: Здесь же можно удалять неактуальные подключения.

                        if (!$result->isSuccess()) {
                            throw new \Error(join("\n", $result->getErrorMessages()));
                        }

                        return "OK";
                    }
                ],
            ];
        };
    }
}
