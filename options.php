<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var \CUser $USER
 * @var \CMain $APPLICATION
 */

$module_id = wjs_api::MODULE_ID;

assert(isset($module_id) && is_string($module_id));
assert(isset($APPLICATION) && $APPLICATION instanceof \CMain);
assert(isset($USER) && $USER instanceof \CUser);

$rights = $APPLICATION->GetGroupRight($module_id);

$canEditOptions = $USER->CanDoOperation('w');

Loader::includeModule($module_id);

Loc::loadMessages(server()->getDocumentRoot() . BX_ROOT . "/modules/main/options.php");
Loc::loadMessages(__FILE__);

$arAllOptions = [
    ["enable", Loc::getMessage("WJS_OPTION_ENABLE"), ["checkbox"]],
];

$aTabs = [
    [
        "DIV" => "edit1",
        "TAB" => Loc::getMessage("MAIN_TAB_SET"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_SET"),
    ],
    /*
    [
        "DIV" => "edit2",
        "TAB" => Loc::getMessage("MAIN_TAB_RIGHTS"),
        "TITLE" => Loc::getMessage("MAIN_TAB_TITLE_RIGHTS"),
    ],
    */
];

$tabControl = new \CAdminTabControl("tabControl", $aTabs);

?>

<?php

if ((request()->getRequestMethod() === "POST") && ($rights === "W") && check_bitrix_sessid()) {
    try {
        if (request()->getPost("RestoreDefaults")) {
            Option::delete($module_id);
        } elseif (request()->getPost("Save")) {
            $defaults = Option::getDefaults($module_id);

            foreach ($arAllOptions as $arOption) {
                Option::set($module_id, $arOption[0], request()->getPost($arOption[0]) ?? $defaults[$arOption[0]]);
            }
        }
    } catch (\Throwable $e) {
        $a = 10;
    }
}

?>

<form method="post"
      action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= urlencode($module_id) ?>&amp;lang=<?= LANGUAGE_ID ?>">
    <?
    $tabControl->Begin();
    $tabControl->BeginNextTab();
    foreach ($arAllOptions as $arOption) {
        $value = \COption::GetOptionString($module_id, $arOption[0]);
        $type = $arOption[2];
        ?>
        <tr>
            <td
                width="40%"
                nowrap
                class="<?= classlist([
                    "adm-detail-valign-top" => $type[0] == "textarea",
                ]) ?>">
                <label
                    for="<?= htmlspecialcharsbx($arOption[0]) ?>">
                    <?= $arOption[1] ?>
                </label>
            <td width="60%">
                <? if ($type[0] == "checkbox"): ?>
                    <input
                        type="checkbox"
                        name="<?= htmlspecialcharsbx($arOption[0]) ?>"
                        id="<?= htmlspecialcharsbx($arOption[0]) ?>"
                        value="Y"
                        <?= attrs([
                            "checked" => $value == "Y",
                        ]) ?>
                    >
                <? elseif ($type[0] == "text"): ?>
                    <input
                        type="text"
                        size="<?= $type[1] ?>"
                        maxlength="255"
                        value="<?= htmlspecialcharsbx($value) ?>"
                        name="<?= htmlspecialcharsbx($arOption[0]) ?>"
                        id="<?= htmlspecialcharsbx($arOption[0]) ?>"
                    >
                <? elseif ($type[0] == "textarea"): ?>
                    <textarea
                        rows="<?= $type[1] ?>"
                        cols="<?= $type[2] ?>"
                        name="<?= htmlspecialcharsbx($arOption[0]) ?>"
                        id="<?= htmlspecialcharsbx($arOption[0]) ?>"><?= htmlspecialcharsbx($value) ?></textarea>
                <? elseif ($type[0] == "selectbox"): ?>
                    <select
                        name="<?= htmlspecialcharsbx($arOption[0]) ?>"
                    >
                        <? foreach ($type[1] as $key => $title): ?>
                            <option
                                value="<?= $key ?>"
                                <?= attrs([
                                    "selected" => $value == $key,
                                ]) ?>
                            >
                                <?= htmlspecialcharsbx($title) ?>
                            </option>
                        <? endforeach; ?>
                    </select>
                <? endif; ?>
            </td>
        </tr>
    <? } ?>
    <? /* $tabControl->BeginNextTab(); ?>
    <? require_once server()->getDocumentRoot() . "/bitrix/modules/main/admin/group_rights2.php"; */ ?>
    <? $tabControl->Buttons(); ?>
    <input
        type="submit"
        name="Save"
        value="<?= Loc::getMessage("MAIN_SAVE") ?>"
        title="<?= Loc::getMessage("MAIN_OPT_SAVE_TITLE") ?>"
        class="adm-btn-save"
        <?= attrs([
            "disabled" => !$canEditOptions,
        ]) ?>
    >

    <input
        type="reset"
        name="reset"
        title="<?= Loc::getMessage("MAIN_RESET") ?>"
        value="<?= Loc::getMessage("MAIN_RESET") ?>"
    >

    <input type="submit"
           name="RestoreDefaults"
           title="<?= Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS") ?>"
           onclick="return confirm('<?= addslashes(Loc::getMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING")) ?>')"
           value="<?= Loc::getMessage("MAIN_RESTORE_DEFAULTS") ?>"
    >

    <?= bitrix_sessid_post(); ?>
    <? $tabControl->End(); ?>
</form>
