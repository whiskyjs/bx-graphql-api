<?php

use Bitrix\Main\Localization\Loc;

use Machaon\Std\Registry;

use WJS\API\Path;

require_once __DIR__ . "/bootstrap/autoload.php";

$registry = Registry::getInstance();
$registry
    ->set("machaon.std.config.files", [
        "default" => Path::getModuleRelativeDir() . "/config.php",
        "local" => Path::getModuleRelativeDir() . "/config.local.php",
    ])
    ->set("machaon.std.logger.dir", Path::getModuleRelativeDir() . "/logs");

Loc::loadMessages(Path::getAbsolutePath("include.php"));
