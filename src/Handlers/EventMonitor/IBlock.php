<?php
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace WJS\API\Handlers\EventMonitor;

use WJS\API\Helpers\EventMonitor\RemoteClient;

class IBlock
{
    /**
     * @param array $arParams
     */
    public static function OnBeforeIBlockElementUpdate(array &$arParams): void
    {
        RemoteClient::getInstance()->broadcastEvent([
            "module" => "main",
            "event" => "OnPageStart",
            "args" => [
                "arParams" => $arParams,
            ],
        ]);
    }
}

// phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
