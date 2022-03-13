<?php namespace Falbar\SystemLog;

use Falbar\SystemLog\Driver\File\Write as FileWrite;
use Falbar\SystemLog\Driver\File\Read as FileRead;

use Falbar\SystemLog\InterfaceList\InterfaceWrite;
use Falbar\SystemLog\InterfaceList\InterfaceRead;

/**
 * Class SystemLog
 * @package Falbar\SystemLog
 */
class SystemLog
{
    const TYPE_EMERGENCY = 'emergency';
    const TYPE_ALERT = 'alert';
    const TYPE_CRITICAL = 'critical';
    const TYPE_ERROR = 'error';
    const TYPE_WARNING = 'warning';
    const TYPE_NOTICE = 'notice';
    const TYPE_INFO = 'info';
    const TYPE_DEBUG = 'debug';
    const TYPE_PROCESSED = 'processed';
    const TYPE_AVAILABLE = [
        self::TYPE_EMERGENCY,
        self::TYPE_ALERT,
        self::TYPE_CRITICAL,
        self::TYPE_ERROR,
        self::TYPE_WARNING,
        self::TYPE_NOTICE,
        self::TYPE_INFO,
        self::TYPE_DEBUG,
        self::TYPE_PROCESSED,
    ];

    const NAMESPACE_DEFAULT = 'default';
    const NAMESPACE_API = 'api';
    const NAMESPACE_WEB = 'web';
    const NAMESPACE_AVAILABLE = [
        self::NAMESPACE_DEFAULT,
        self::NAMESPACE_API,
        self::NAMESPACE_WEB,
    ];

    const DRIVER_FILE = 'file';

    /**
     * @param string $sDriver
     *
     * @return InterfaceWrite|null
     */
    public static function write(string $sDriver = self::DRIVER_FILE): ?InterfaceWrite
    {
        if ($sDriver == self::DRIVER_FILE) {
            return new FileWrite;
        }

        return null;
    }

    /**
     * @param string $sDriver
     *
     * @return InterfaceRead|null
     */
    public static function read(string $sDriver = self::DRIVER_FILE): ?InterfaceRead
    {
        if ($sDriver == self::DRIVER_FILE) {
            return new FileRead;
        }

        return null;
    }
}
