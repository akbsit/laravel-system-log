<?php namespace Falbar\SystemLog\Driver\File;

use Falbar\SystemLog\Driver\AbstractDriver;
use Falbar\SystemLog\SystemLog;

/**
 * Class AbstractFile
 * @package Falbar\SystemLog\Driver\File
 */
abstract class AbstractFile extends AbstractDriver
{
    const BASE_DIR = 'logs';

    /* @return string */
    protected function getStoragePath(): string
    {
        $sResult = '';

        switch ($this->sNameSpace) {
            case SystemLog::NAMESPACE_ROOT:
                $sResult = storage_path(self::BASE_DIR);
                break;
            case SystemLog::NAMESPACE_DEFAULT:
            case SystemLog::NAMESPACE_WEB:
            case SystemLog::NAMESPACE_API:
                $sResult = storage_path(self::BASE_DIR . '/' . $this->sNameSpace);
                break;
        }

        return $sResult;
    }
}
