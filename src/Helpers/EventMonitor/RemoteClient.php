<?php

namespace WJS\API\Helpers\EventMonitor;

use Bitrix\Main\ArgumentNullException;
use Bitrix\Main\ArgumentOutOfRangeException;
use Bitrix\Main\Config\Option;

use Machaon\Std\Base\Singleton;
use Machaon\Std\Url;

use WJS\API\Entities\SubscriberTable;
use WJS\API\MetaInfo;

class RemoteClient extends Singleton
{
    /**
     * Путь для отправки событий с
     */
    const ROUTE_REMOTE_EVENT = "/remote/event/";

    const DEFAULT_TIMEOUT = 1000;

    /**
     * @param string $route
     * @return Url
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     */
    protected static function getRoutePath(string $route): Url
    {
        $proxyServer = Option::get(
            MetaInfo::getInstance()->getModuleName(),
            "proxy_server"
        );

        $url = Url::from($proxyServer);

        return $url->setPathSegments(explode("/", trim($route, "/")));
    }

    /**
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * RemoteClient constructor.
     * @throws \Exception
     */
    protected function __construct()
    {
        $this->logger = logger(static::class);
    }

    /**
     * @param array $payload
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function broadcastEvent(array $payload): void
    {
        if (!$this->shouldBroadcastEvents()) {
            return;
        }

        try {
            $metadata = $this->getMetadata($payload);

            if (!$metadata["subscribers"]) {
                return;
            }

            static::postMessage(static::getRoutePath(static::ROUTE_REMOTE_EVENT), [
                "payload" => $this->addServicePayload($payload),
                "meta" => $metadata,
            ]);
        } catch (\Throwable $err) {
            $this->logger->err($err->getMessage());
        }
    }

    /**
     * @param array $payload
     * @return array
     */
    public function addServicePayload(array $payload): array
    {
        return array_merge($payload, [
            "time" => time(),
        ]);
    }

    /**
     * @param string $url
     * @param array $data
     * @return mixed
     * @throws \JsonException
     */
    public static function postMessage(string $url, array $data)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, to_json($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, static::DEFAULT_TIMEOUT);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    /**
     * @param array $payload
     * @return array
     * @throws ArgumentNullException
     * @throws ArgumentOutOfRangeException
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getMetadata(array $payload): array
    {
        return [
            "origin" => Option::get(
                MetaInfo::getInstance()->getModuleName(),
                "origin"
            ),
            "subscribers" => $this->getEventSubscribers($payload["module"], $payload["event"]),
        ];
    }

    /**
     * MySQL - не PostgreSQL, запрос по JSON делать не умеет, поэтому придется вытаскивать _всех_
     * подписчиков из БД (их редко будет больше 5-10), и затем фильтровать вручную.
     *
     * @param string $module
     * @param string $eventName
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    protected function getEventSubscribers(string $module, string $eventName): array
    {
        $result = [];

        foreach (SubscriberTable::getList()->fetchAll() as $subscriber) {
            /**
             * @var array $subscriber
             */

            if (isset($subscriber["EVENTS"][$module]) && in_array($eventName, $subscriber["EVENTS"][$module])) {
                $result[] = $subscriber["UUID"];
            }
        }

        return $result;
    }

    /**
     * @return bool
     */
    protected function shouldBroadcastEvents(): bool
    {
        return (bool) request()->getCookieRaw(config("wjs.api.event_monitor.cookie_name"));
    }
}
