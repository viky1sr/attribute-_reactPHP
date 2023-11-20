<?php

namespace Jamkrindo\Lib;

class ConfigLoaderProvider
{
    private static $config = [];

    public static function load($configDirectory): void
    {
        $configFiles = glob($configDirectory . '/*.php');
        foreach ($configFiles as $configFile) {
            if(!is_int(strpos($configFile,'helper.php'))){
                $configName = pathinfo($configFile, PATHINFO_FILENAME);
                self::$config[$configName] = include $configFile;
            }
        }
    }

    public static function get($configName, $key = null, $default = null)
    {
        if (!isset(self::$config[$configName])) {
            return $default;
        }

        if ($key === null) {
            return self::$config[$configName];
        }

        $keys = explode('.', $key);
        $value = self::$config[$configName];

        foreach ($keys as $nestedKey) {
            if (isset($value[$nestedKey])) {
                $value = $value[$nestedKey];
            } else {
                return $default;
            }
        }

        return $value;
    }
}
