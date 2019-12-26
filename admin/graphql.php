<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

use WJS\API\MetaInfo;
use WJS\API\Path;

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php";

/**
 * @var \CUser $USER
 * @var \CMain $APPLICATION
 */

Loader::includeModule("wjs.api");

$metaInfo = MetaInfo::getInstance();
$module_id = $metaInfo->getModuleName();

assert(isset($module_id) && is_string($module_id));
assert(isset($APPLICATION) && $APPLICATION instanceof \CMain);
assert(isset($USER) && $USER instanceof \CUser);

/** @noinspection PhpIncludeInspection */
require_once Path::getAbsolutePath("prolog.php");

$APPLICATION->SetTitle(Loc::getMessage("WJS_ADMIN_TOOL_TITLE"));

require $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_after.php";

$scripts = [
    "runtime",
    "vendors",
    "graphiql",
];

foreach ($scripts as $script) {
    /** @noinspection HtmlUnknownTarget */
    asset()->addString(format('<script src="{path}"></script>', [
        "path" => Path::getJsPath($script),
    ]));
}

$styles = [
    "graphiql",
];

foreach ($styles as $style) {
    /** @noinspection HtmlUnknownTarget */
    asset()->addString(format('<link rel="stylesheet" type="text/css" href="{path}">', [
        "path" => Path::getCssPath($style),
    ]));
}

?>

    <div id="graphiql-anchor"></div>

<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php";
