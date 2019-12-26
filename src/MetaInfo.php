<?php

namespace WJS\API;

use Machaon\Std\Base\Singleton;

class MetaInfo extends Singleton
{
    /**
     * @var array
     */
    protected $arModuleVersion;

    protected function __construct()
    {
        /** @noinspection PhpIncludeInspection */
        include Path::getAbsolutePath("/install/version.php");

        /**
         * @var array $arModuleVersion
         */

        assert(isset($arModuleVersion) && is_array($arModuleVersion));

        $this->arModuleVersion = $arModuleVersion;
    }

    /**
     * @return string
     */
    public function getModuleVersion(): string
    {
        return $this->arModuleVersion["VERSION"];
    }

    /**
     * @return string
     */
    public function getModuleDate(): string
    {
        return $this->arModuleVersion["VERSION_DATE"];
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return $this->arModuleVersion["NAME"];
    }
}
