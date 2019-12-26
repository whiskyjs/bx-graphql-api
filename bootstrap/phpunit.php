<?php

if (!isset($_SERVER["DOCUMENT_ROOT"]) || !$_SERVER["DOCUMENT_ROOT"]) {
    $_SERVER["DOCUMENT_ROOT"] = realpath(__DIR__ . "/../");
    $GLOBALS["DOCUMENT_ROOT"] = $_SERVER["DOCUMENT_ROOT"];
}

require_once __DIR__ . "/autoload.php";
