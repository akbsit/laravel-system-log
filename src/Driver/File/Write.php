<?php namespace Akbsit\SystemLog\Driver\File;

use Akbsit\SystemLog\InterfaceList\InterfaceWrite;
use Akbsit\HelperJson\JsonHelper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;

use Carbon\Carbon;
use Exception;

/**
 * Class Write
 * @package Akbsit\SystemLog\Driver\File
 */
class Write extends AbstractFile implements InterfaceWrite
{
    private const CHMOD_MODE = 0777;

    /* @return bool */
    public function put(): bool
    {
        try {
            $sLogDirPath = $this->getStoragePath();
            $this->chmod($sLogDirPath);

            if (!File::isDirectory($sLogDirPath)) {
                File::makeDirectory($sLogDirPath);
            }

            $sLogFilePath = $sLogDirPath . '/' . $this->sNameSpace . '-' . date('Y-m-d') . '.log';
            $this->chmod($sLogFilePath);

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

        $arContextInfo = Arr::get($this->arContext, 'info');
        $arContextData = Arr::get($this->arContext, 'data');
        if (!empty($arContextInfo) || !empty($arContextData)) {
            $sLogLine .= ' ' . JsonHelper::make()->data($this->arContext)->encode();
        }

        $sLogLine .= PHP_EOL;

        return $sLogLine;
    }

    /**
     * @param string $sFilePath
     *
     * @return void
     */
    private function chmod(string $sFilePath): void
    {
        if (!File::exists($sFilePath)) {
            return;
        }

        if ((string)File::chmod($sFilePath) === '0' . decoct(self::CHMOD_MODE)) {
            return;
        }

        File::chmod($sFilePath, self::CHMOD_MODE);
    }
}
