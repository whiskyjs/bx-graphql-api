<?php

use Bitrix\Main\Loader;

/**
 * @var string $module Код модуля
 */

if (!isset($module)) {
    $module = (new whiskyjs_api())->MODULE_ID;
}

Loader::includeModule($module)

?>

<div id="api-options">
    Опции модуля
</div>
