<?php
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace WJS\API\EventHandlers;

use WJS\API\EventMonitor\RemoteClient;

class EventProcessor
{
    /**
     * @param array $metadata
     * @param array ...$rest
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public static function handleEvent(array $metadata, ...$rest): void
    {
        $minCommonLength = min(count($metadata), count($rest));

        RemoteClient::getInstance()->broadcastEvent([
            "module" => $metadata["module"],
            "event" => $metadata["event"],
            "args" => array_combine(
                array_slice($metadata["args"], 0, $minCommonLength),
                array_slice($rest, 0, $minCommonLength)
            ),
        ]);
    }
}

// phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
