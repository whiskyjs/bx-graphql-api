<?php

use Bitrix\Main\Localization\Loc;

global $APPLICATION;

if (!check_bitrix_sessid()) {
    return;
}

$message = new \CAdminMessage([
    "MESSAGE" => Loc::getMessage("MOD_UNINST_OK"),
    "TYPE" => "OK",
]);
echo $message->Show();
?>

<form action="<?= $APPLICATION->GetCurPage() ?>">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="submit" name="" value="<?= Loc::getMessage("MOD_BACK") ?>">
    <form>
