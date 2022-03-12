<?php namespace Falbar\SystemLog\Helper;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

use Symfony\Component\Finder\SplFileInfo;
use Falbar\SystemLog\SystemLog;

/**
 * Class FileParser
 * @package Falbar\SystemLog\Helper
 */
class FileParser
{
    private const MAX_FILE_SIZE = 52428800;

    private const LOG_REGEX_LARAVEL_FILE = '/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?\].*/';
    private const LOG_REGEX_LARAVEL_FILE_LEVEL = [
        'BEFORE' => '/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}([\+-]\d{4})?)\](?:.*?(\w+)\.|.*?)',
        'AFTER'  => ': (.*?)( in .*?:[0-9]+)?$/i',
    ];
    private const LOG_REGEX_LARAVEL_FILE_STACK = '/^\n*/';

    /* @var SplFileInfo */
    private static $oFile;

    /**
     * @param SplFileInfo $oFile
     *
     * @return void
     */
    public static function setFile(SplFileInfo $oFile): void
    {
        $oFilesystem = new Filesystem;
        if ($oFilesystem->exists($oFile)) {
            static::$oFile = $oFile;
        }
    }

    /* @return void */
    public static function clearFile(): void
    {
        static::$oFile = null;
    }

    /**
     * @return array
     *
     * @throws FileNotFoundException
     */
    public static function getAll(): array
    {
        $arResult = [];
        if (empty(static::$oFile)) {
            return $arResult;
        }

        $oFilesystem = new Filesystem;
        if ($oFilesystem->size(self::$oFile) > self::MAX_FILE_SIZE) {
            return $arResult;
        }

        $sFile = $oFilesystem->get(static::$oFile);
        if (empty($sFile)) {
            return $arResult;
        }

        preg_match_all(self::LOG_REGEX_LARAVEL_FILE, $sFile, $arHeadings);
        if (empty($arHeadings) || empty(is_array($arHeadings))) {
            return $arResult;
        }

        $arLogData = preg_split(self::LOG_REGEX_LARAVEL_FILE, $sFile);
        if (Arr::get($arLogData, '0') < 1) {
            array_shift($arLogData);
        }

        foreach ($arHeadings as $sHead) {
            for ($iI = 0, $iJ = count($sHead); $iI < $iJ; $iI++) {
                foreach (SystemLog::TYPE_AVAILABLE as $sLevel) {
                    if (strpos(strtolower($sHead[$iI]), '.' . $sLevel) ||
                        strpos(strtolower($sHead[$iI]), $sLevel . ':')) {
                        preg_match(self::LOG_REGEX_LARAVEL_FILE_LEVEL['BEFORE'] . $sLevel . self::LOG_REGEX_LARAVEL_FILE_LEVEL['AFTER'], $sHead[$iI], $arCurrent);
                        if (empty(Arr::has($arCurrent, '4'))) {
                            continue;
                        }

                        $arResult[] = [
                            'context' => Arr::get($arCurrent, '3'),
                            'level'   => $sLevel,
                            'date'    => Arr::get($arCurrent, '1'),
                            'text'    => Arr::get($arCurrent, '4'),
                            'in_file' => Arr::get($arCurrent, '5'),
                            'stack'   => preg_replace(self::LOG_REGEX_LARAVEL_FILE_STACK, '', $arLogData[$iI]),
                        ];
                    }
                }
            }
        }

        rsort($arResult);

        return $arResult;
    }
}
