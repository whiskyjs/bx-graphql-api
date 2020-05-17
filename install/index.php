<?php
// phpcs:disable PSR1.Files.SideEffects
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
// phpcs:disable Squiz.Classes.ValidClassName.NotCamelCaps

use Bitrix\Main\Application;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Context;
use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;

use WJS\API\GraphQL\Schema\Types\ModuleEventSetInput;

Loc::loadMessages(__FILE__);

class wjs_api extends \CModule
{
    const MODULE_ID = "wjs.api";

    /**
     * @var string
     */
    public $MODULE_ID = self::MODULE_ID;

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

        $this->MODULE_NAME = Loc::getMessage("WJS_MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::getMessage("WJS_INSTALL_DESCRIPTION");

        $this->PARTNER_NAME = "Александр Селюченко";
        $this->PARTNER_URI = "https://segfault.pro";

        /** @noinspection PhpIncludeInspection */
        include_once realpath(__DIR__ . "/../vendor/autoload.php");
    }

    /**
     * @param bool $installWizard
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallDB($installWizard = true): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        RegisterModule($this->MODULE_ID);

        /** @noinspection PhpIncludeInspection */
        include_once realpath(__DIR__ . "/../src/Entities/SubscriberTable.php");

        $db = Application::getConnection();
        $messageEntity = WJS\API\Entities\SubscriberTable::getEntity();

        if (!$db->isTableExists($messageEntity->getDBTableName())) {
            $messageEntity->createDbTable();
        } else {
            // Таблица уже существует, не делам ничего
            // TODO: Миграции
        }

        // Генерируем псевдоуникальный идентификатор копии, если уже не существует
        if (!Option::get($this->MODULE_ID, "origin")) {
            Option::set($this->MODULE_ID, "origin", uniqid("", true));
        }

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
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallEvents(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        EventManager::getInstance()->registerEventHandlerCompatible(
            "main",
            "OnBuildGlobalMenu",
            $this->MODULE_ID,
            \WJS\API\Handlers\Main::class,
            "onBuildGlobalMenu"
        );

        EventManager::getInstance()->registerEventHandlerCompatible(
            "main",
            "OnEpilog",
            $this->MODULE_ID,
            \WJS\API\Handlers\Main::class,
            "onEpilog"
        );

        $this->InstallTraceableEvents();

        return true;
    }

    /**
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    protected function InstallTraceableEvents(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        foreach ($this->iterateTraceableEvents() as [$module, $event, $args]) {
            EventManager::getInstance()->registerEventHandlerCompatible(
                $module,
                $event,
                $this->MODULE_ID,
                \WJS\API\Handlers\EventMonitor\EventProcessor::class,
                "handleEvent",
                100,
                "",
                [[
                    "module" => $module,
                    "event" => $event,
                    "args" => $args,
                ]]
            );
        }
    }

    /**
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    protected function UninstallTraceableEvents(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        foreach ($this->iterateTraceableEvents() as [$module, $event, $args]) {
            EventManager::getInstance()->unRegisterEventHandler(
                $module,
                $event,
                $this->MODULE_ID,
                \WJS\API\Handlers\EventMonitor\EventProcessor::class,
                "handleEvent",
                "",
                [[
                    "module" => $module,
                    "event" => $event,
                    "args" => $args,
                ]]
            );
        }
    }

    /**
     * @return Generator
     */
    protected function iterateTraceableEvents(): \Generator
    {
        $eventSet = new ModuleEventSetInput();

        foreach ($eventSet->getFields() as $moduleId => $field) {
            /**
             * @var \GraphQL\Type\Definition\InputObjectField $field
             */

            $rootType = $field->getType();

            while (!$rootType instanceof \GraphQL\Type\Definition\EnumType) {
                $rootType = (function () {
                    /**
                     * @var $this GraphQL\Type\Definition\Type
                     */

                    return $this->ofType;
                })->bindTo($rootType, get_class($rootType))->call($rootType);
            }

            foreach ($rootType->getValues() as $enumValue) {
                /**
                 * @var \GraphQL\Type\Definition\EnumValueDefinition $enumValue
                 */

                yield [$moduleId, $enumValue->name, $enumValue->config["args"] ?? []];
            }
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function UnInstallEvents(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnBuildGlobalMenu",
            $this->MODULE_ID,
            \WJS\API\Handlers\Main::class,
            "onBuildGlobalMenu"
        );

        EventManager::getInstance()->unRegisterEventHandler(
            "main",
            "OnEpilog",
            $this->MODULE_ID,
            \WJS\API\Handlers\Main::class,
            "onEpilog"
        );

        $this->UninstallTraceableEvents();

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function InstallFiles(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        CopyDirFiles(
            sprintf(
                "%s/bitrix/modules/%s/install/admin",
                $_SERVER["DOCUMENT_ROOT"],
                $this->MODULE_ID
            ),
            sprintf(
                "%s/bitrix/admin",
                $_SERVER["DOCUMENT_ROOT"]
            ),
            true
        );

        CopyDirFiles(
            sprintf(
                "%s/bitrix/modules/%s/install/tools",
                $_SERVER["DOCUMENT_ROOT"],
                $this->MODULE_ID
            ),
            sprintf(
                "%s/bitrix/tools",
                $_SERVER["DOCUMENT_ROOT"]
            ),
            true
        );

        return true;
    }

    /**
     * @return bool
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function UnInstallFiles(): bool
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        DeleteDirFiles(
            sprintf(
                "%s/bitrix/modules/%s/install/admin",
                $_SERVER["DOCUMENT_ROOT"],
                $this->MODULE_ID
            ),
            sprintf(
                "%s/bitrix/admin",
                $_SERVER["DOCUMENT_ROOT"]
            )
        );

        DeleteDirFiles(
            sprintf(
                "%s/bitrix/modules/%s/install/tools",
                $_SERVER["DOCUMENT_ROOT"],
                $this->MODULE_ID
            ),
            sprintf(
                "%s/bitrix/tools",
                $_SERVER["DOCUMENT_ROOT"]
            )
        );

        return true;
    }

    /**
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\SystemException
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function DoInstall(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        global $APPLICATION;

        $this->InstallFiles();
        $this->InstallDB(false);
        $this->InstallEvents();

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WJS_INSTALL_TITLE"),
            sprintf(
                "%s/bitrix/modules/%s/install/step.php",
                Context::getCurrent()->getServer()->getDocumentRoot(),
                $this->MODULE_ID
            )
        );
    }

    /**
     * @throws Exception
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function DoUninstall(): void
    {
        // phpcs:enable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

        global $APPLICATION;

        $this->UnInstallDB();
        $this->UnInstallFiles();
        $this->UnInstallEvents();

        $APPLICATION->IncludeAdminFile(
            Loc::getMessage("WJS_UNINSTALL_TITLE"),
            sprintf(
                "%s/bitrix/modules/%s/install/unstep.php",
                Context::getCurrent()->getServer()->getDocumentRoot(),
                $this->MODULE_ID
            )
        );
    }
}
