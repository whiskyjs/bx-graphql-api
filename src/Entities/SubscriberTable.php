<?php

namespace WJS\API\Entities;

use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DataManager;

class SubscriberTable extends DataManager
{
    const INACTIVE_TIMEOUT = 6 * 3600;

    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'wjs_api_subscribers';
    }

    /**
     * @return array
     * @throws \Bitrix\Main\SystemException
     */
    public static function getMap()
    {
        return [
            new StringField("UUID", [
                "title" => 'UUID',
                "required" => true,
                "primary" => true,
            ]),

            new IntegerField('CREATED_AT', [
                'title' => 'Дата первого подключения клиента',
                'required' => false,
                'default_value' => function () {
                    return time();
                },
            ]),

            new IntegerField('UPDATED_AT', [
                'title' => 'Дата последнего доступа клиента',
                'required' => false,
                'default_value' => function () {
                    return time();
                },
            ]),

            new StringField('EVENTS', [
                "title" => 'Опции подписки: список событий и фильтры',
                'required' => false,
                'default_value' => function () {
                    return [];
                },
                'save_data_modification' => function () {
                    return [
                        function ($value) {
                            return serialize($value);
                        },
                    ];
                },
                'fetch_data_modification' => function () {
                    return [
                        function ($value) {
                            return unserialize($value);
                        },
                    ];
                },
            ]),
        ];
    }

    /**
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Exception
     */
    public static function deleteInactiveClients(): void
    {
        $inactiveClients = static::getList([
            "filter" => [
                "<UPDATED_AT" => time() - static::INACTIVE_TIMEOUT,
            ],
            "select" => [
                "UUID",
            ],
        ])->fetchAll();

        foreach ($inactiveClients as $inactiveClient) {
            static::delete($inactiveClient["UUID"]);
        }
    }
}
