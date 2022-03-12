<?php namespace Falbar\SystemLog\Driver\File;

use Falbar\SystemLog\InterfaceList\InterfaceWrite;
use Falbar\HelperJson\JsonHelper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

use Carbon\Carbon;
use Exception;

/**
 * Class Write
 * @package Falbar\SystemLog\Driver\File
 */
class Write extends AbstractFile implements InterfaceWrite
{
    private const DIR_MODE = 0777;

    /* @return bool */
    public function put(): bool
    {
        try {
            $sLogDirPath = $this->getStoragePath();
            if (empty(File::isDirectory($sLogDirPath))) {
                File::makeDirectory($sLogDirPath, self::DIR_MODE, true, true);
            }

            $sLogFilePath = $sLogDirPath . '/' . $this->sNameSpace . '-' . date('Y-m-d') . '.log';
            if (!File::append($sLogFilePath, $this->getLogLine())) {
                return false;
            }
        } catch (Exception $oException) {
            return false;
        }

        return true;
    }

    /* @return string */
    private function getLogLine(): string
    {
        $sLogLine = '[' . Carbon::now()->toDateTimeString() . ']';
        $sLogLine .= ' ' . $this->sType . ':';

        if (!empty($this->sMessage)) {
            $sLogLine .= ' ' . $this->sMessage;
        }

        $arContextData = Arr::get($this->arContext, 'data');
        if (!empty($arContextData)) {
            $sLogLine .= ' ' . JsonHelper::make()->data($arContextData)->encode();
        }

        $sLogLine .= PHP_EOL;

        return $sLogLine;
    }
}
