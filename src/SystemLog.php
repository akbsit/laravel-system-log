<?php namespace Falbar\SystemLog;

use Falbar\SystemLog\Driver\File\Write as FileWrite;
use Falbar\SystemLog\Driver\File\Read as FileRead;

/**
 * Class SystemLog
 * @package Falbar\SystemLog
 */
class SystemLog
{
    const ERROR = 'error';

    const NAMESPACE_API = 'api';
    const NAMESPACE_WEB = 'web';

    const DRIVER_FILE = 'file';

    /**
     * @param string $sDriver
     *
     * @return mixed
     */
    public static function write(string $sDriver = self::DRIVER_FILE): ?FileWrite
    {
        switch ($sDriver) {
            case self::DRIVER_FILE:
                return new FileWrite;
        }

        return null;
    }

    /**
     * @param string $sDriver
     *
     * @return mixed
     */
    public static function read(string $sDriver = self::DRIVER_FILE): ?FileRead
    {
        switch ($sDriver) {
            case self::DRIVER_FILE:
                return new FileRead;
        }

        return null;
    }
}
