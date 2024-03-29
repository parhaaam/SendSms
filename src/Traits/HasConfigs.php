<?php

namespace Parhaaam\SendSms\Traits;

trait HasConfigs
{
    /**
     * Retrieve default config.
     *
     * @return array
     */
    protected static function getConfigs(): array
    {
        return require(static::getConfigPath());
    }

    /**
     * Retrieve Default config's path.
     *
     * @return string
     */
    protected static function getConfigPath(): string
    {
        return  __DIR__ . '/../../config/sendsms.php';
    }

    /**
     * Return related driver specs to driver key
     *
     * @return array
     */
    protected static function getDriverFromConfigs(string $driverKey): array
    {
        self::checkConfigHasDriver($driverKey);

        return self::getDrivePathInConfigs()[$driverKey];
    }

    /**
     * Return driver array from configs
     *
     * @return array
     */
    protected static function getDrivePathInConfigs(): array
    {
        return  self::getConfigs()['drivers'];
    }

    /**
     * check driver has the given key
     *
     * @return void
     */
    protected static function CheckDriverConfigsKeyExists(string $driver, string $key): void
    {
        if (! isset(static::getDriverFromConfigs($driver)[$key])) {
            throw new \InvalidArgumentException("[$driver] is does not have the [$key] in sendSms configs at config/sendsms.php");
        }
    }

    /**
     * Return specefic data from driver configs using the given key
     *
     * @return array|string
     */
    public static function getDriverConfigsByKey(string $driver, string $key): array|string
    {
        static::CheckDriverConfigsKeyExists($driver,  $key);

        return static::getDriverFromConfigs($driver)[$key];
    }

    /**
     * Checks if driver is defined in configs
     *
     * @return void
     */
    protected static function checkConfigHasDriver(string $driverKey): void
    {
        if (! isset(self::getDrivePathInConfigs()[$driverKey])) {
            throw new \InvalidArgumentException("[$driverKey] is not defined in sendSms configs at config/sendsms.php");
        }
    }
}
