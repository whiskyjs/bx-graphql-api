<?php
// phpcs:disable PSR1.Files.SideEffects

if (!isset($_SERVER["DOCUMENT_ROOT"]) || !$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . "/../../../..");
    $GLOBALS["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"];
}

define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define("BX_CRONTAB", true);
define("BX_NO_ACCELERATOR_RESET", true);

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";
require_once($_SERVER["DOCUMENT_ROOT"] . BX_ROOT . "/modules/main/interface/admin_lib.php");
