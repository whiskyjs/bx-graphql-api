<?php

namespace WJS\API\Helpers\EventMonitor;

use Machaon\Std\Base\Singleton;

class RemoteClient extends Singleton
{
    /**
     * @param array $payload
     */
    public function broadcastEvent(array $payload): void
    {
        // TODO: Отсылка и ретрансляция. Вынести URL в опции модуля.
    }
}
