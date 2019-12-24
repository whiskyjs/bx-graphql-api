<?php
// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

use Bitrix\Main\Context;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class whiskyjs_api extends \CModule
{
    /**
     * @var string
     */
    public $MODULE_ID = "whiskyjs.api";

    /**
     * @var string
     */
    public $MODULE_VERSION;

    /**
     * @var string
     */
    public $MODULE_VERSION_DATE;

    /**
     * @var string|string[]
     */
    public $MODULE_NAME;

    /**
     * @var string|string[]
     */
    public $MODULE_DESCRIPTION;

    public function __construct()
    {
        $arModuleVersion = [];

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));

        /** @noinspection PhpIncludeInspection */
        include sprintf("%s/version.php", $path);

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = Loc::getMessage("WA_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("WA_INSTALL_DESCRIPTION");
    }

    /**
     * @param bool $installWizard
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallDB($installWizard = true): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        RegisterModule($this->MODULE_ID);

        return true;
    }

    /**
     * @param array $arParams
     * @return bool|void
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function UnInstallDB($arParams = []): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        UnRegisterModule($this->MODULE_ID);

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallEvents(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function UnInstallEvents(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallFiles(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function UnInstallFiles(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        return true;
    }

    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function DoInstall(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        global $APPLICATION;

        $this->InstallFiles();
        $this->InstallDB(false);
        $this->InstallEvents();

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WA_INSTALL_TITLE"),
            sprintf(
                "%s/bitrix/modules/%s/install/step.php",
                Context::getCurrent()->getServer()->getDocumentRoot(),
                $this->MODULE_ID
            )
        );
    }

    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function DoUninstall(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WA_UNINSTALL_TITLE"),
            sprintf(
                "%s/bitrix/modules/%s/install/unstep.php",
                Context::getCurrent()->getServer()->getDocumentRoot(),
                $this->MODULE_ID
            )
        );
    }
}
