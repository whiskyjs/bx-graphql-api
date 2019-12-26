<?php

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

use Bitrix\Main\Loader;

use WJS\API\GraphQL\Schema\Builder;
use WJS\API\GraphQL\Server;

Loader::includeModule("wjs.api");

Builder::getInstance()->registerFields([
    \WJS\API\GraphQL\Schema\Types\Extend\InspectType\Version::class,
    \WJS\API\GraphQL\Schema\Types\Extend\InspectType\Evaluate::class,
]);

Server::getInstance()->handleRequest();

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_after.php";
