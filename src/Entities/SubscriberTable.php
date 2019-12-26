<?php

namespace WJS\API\Entities;

use Bitrix\Main\Type\DateTime as BxDateTime;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\DatetimeField;

class SubscriberTable extends DataManager
{
    /**
     * @return string
     */
    public static function getTableName()
    {
        return 'wjs_api_subscriber_table';
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

            new DatetimeField('CREATED_AT', [
                'title' => 'Дата первого подключения клиента',
                'required' => false,
                'default_value' => function () {
                    return new BxDateTime();
                },
                'validation' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof BxDateTime || $value instanceof \DateTime) {
                                return true;
                            }

                            return false;
                        },
                    ];
                },
                'save_data_modification' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof \DateTime) {
                                return BxDateTime::createFromPhp($value);
                            }

                            return $value;
                        },
                    ];
                },
                'fetch_data_modification' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof BxDateTime) {
                                return $value->toString();
                            }

                            return $value;
                        },
                    ];
                },
            ]),

            new DatetimeField('UPDATED_AT', [
                'title' => 'Дата последнего доступа клиента',
                'required' => false,
                'default_value' => function () {
                    return new BxDateTime();
                },
                'validation' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof BxDateTime || $value instanceof \DateTime) {
                                return true;
                            }

                            return false;
                        },
                    ];
                },
                'save_data_modification' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof \DateTime) {
                                return BxDateTime::createFromPhp($value);
                            }

                            return $value;
                        },
                    ];
                },
                'fetch_data_modification' => function () {
                    return [
                        function ($value) {
                            if ($value instanceof BxDateTime) {
                                return $value->toString();
                            }

                            return $value;
                        },
                    ];
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
}
