<?php

namespace WJS\API;

class Path
{
    /**
     * @return string
     */
    public static function getModuleRelativeDir(): string
    {
        return substr(static::getModuleRoot(), strlen(server()->getDocumentRoot()));
    }

    /**
     * @return string
     */
    public static function getModuleRoot(): string
    {
        return realpath(__DIR__ . "/../");
    }

    /**
     * @param string $innerFilePath
     * @return string
     */
    public static function getAbsolutePath(string $innerFilePath): string
    {
        return static::getModuleRoot() . "/" . ltrim(trim($innerFilePath), "/");
    }

    /**
     * @param string $innerFilePath
     * @return string
     */
    public static function getRelativePath(string $innerFilePath): string
    {
        return static::getModuleRelativeDir() . "/" . ltrim(trim($innerFilePath), "/");
    }

    /**
     * @param string $fileName
     * @param bool $absolute
     * @return string
     */
    public static function getJsPath(string $fileName, bool $absolute = false): string
    {
        if (!preg_match("#\.js$#", $fileName)) {
            $fileName .= ".js";
        }

        if ($absolute) {
            return static::getAbsolutePath("/app/dist/js/$fileName");
        }

        return static::getRelativePath("/app/dist/js/$fileName");
    }

    /**
     * @param string $fileName
     * @param bool $absolute
     * @return string
     */
    public static function getCssPath(string $fileName, bool $absolute = false): string
    {
        if (!preg_match("#\.css$#", $fileName)) {
            $fileName .= ".css";
        }

        if ($absolute) {
            return static::getAbsolutePath("/app/dist/css/$fileName");
        }

        return static::getRelativePath("/app/dist/css/$fileName");
    }
}
