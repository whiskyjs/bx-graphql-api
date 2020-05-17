<?php

use Bitrix\Main\Localization\Loc;

use Machaon\Std\Registry;

use WJS\API\Path;

require_once __DIR__ . "/bootstrap/autoload.php";

$registry = Registry::getInstance();

$registry->apply("machaon.std.config.files", function ($current) {
    if (isset($current)) {
        $files = $current;
    } else {
        try {
            $files = config("machaon.std.config.files");
        } catch (\Throwable $err) {
            $config  = require "vendor/machaon/std/src/config.php";
            $files = $config["machaon"]["std"]["config"]["files"];
        }
    }

    return array_merge([
        "wjs.api" => Path::getModuleRelativeDir() . "/config.php",
        "wjs.api.local" => Path::getModuleRelativeDir() . "/config.local.php",
    ], $files);
});

// Сбрасываем текущую конфигурацию, чтобы config() обновила кеш
$registry->remove("config");

Loc::loadMessages(Path::getAbsolutePath("include.php"));
