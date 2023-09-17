<?php namespace Akbsit\SystemLog\Driver\File;

use Akbsit\SystemLog\Driver\AbstractDriver;
use Akbsit\SystemLog\SystemLog;

/**
 * Class AbstractFile
 * @package Akbsit\SystemLog\Driver\File
 */
abstract class AbstractFile extends AbstractDriver
{
    const BASE_DIR = 'logs';

    /* @return string */
    protected function getStoragePath(): string
    {
        $sResult = '';

        switch ($this->sNameSpace) {
            case SystemLog::NAMESPACE_DEFAULT:
                $sResult = storage_path(self::BASE_DIR);
                break;
            case SystemLog::NAMESPACE_WEB:
            case SystemLog::NAMESPACE_API:
                $sResult = storage_path(self::BASE_DIR . '/' . $this->sNameSpace);
                break;
        }

        return $sResult;
    }
}
