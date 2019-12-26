<?php

namespace WJS\API\Handlers;

use Bitrix\Main\Localization\Loc;
use WJS\API\Path;

class Main
{
    /**
     * @param array $arGlobalMenu
     * @param array $arModuleMenu
     */
    public static function onBuildGlobalMenu(array &$arGlobalMenu, array &$arModuleMenu)
    {
        foreach ($arModuleMenu as $k => $v) {
            if ($v['parent_menu'] == 'global_menu_settings' && $v['icon'] == 'util_menu_icon') {
                $arModuleMenu[$k]['items'][] = [
                    'text' => Loc::getMessage("WJS_ADMIN_TOOL_TITLE"),
                    'title' => Loc::getMessage("WJS_ADMIN_TOOL_TITLE"),
                    'url' => 'wjs_api_graphql.php?lang=' . LANGUAGE_ID,
                    'more_url' => ['graphql.php'],
                ];

                break;
            }
        }
    }

    public static function onEpilog(): void
    {
        if (request()->isAdminSection()) {
            /** @noinspection PhpIncludeInspection */
            asset()->addString(
                '<script type="text/javascript">window.config = '
                . json_encode(require Path::getAbsolutePath("config.public.php"))
                . ';</script>'
            );
        }
    }
}
