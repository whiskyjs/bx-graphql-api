<?php
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace WJS\API\Handlers\EventMonitor;

use WJS\API\Helpers\EventMonitor\RemoteClient;

class Main
{
    /**
     * TODO: Загнать в классы, обобщить.
     */
    public static function OnPageStart(): void
    {
        RemoteClient::getInstance()->broadcastEvent([
            "module" => "main",
            "event" => "OnPageStart",
            "args" => [],
        ]);
    }
}

// phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
