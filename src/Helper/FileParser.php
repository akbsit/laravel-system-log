<?php namespace Falbar\SystemLog\Helper;

use Symfony\Component\Finder\SplFileInfo;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;

/**
 * Class FileParser
 * @package Falbar\SystemLog\Helper
 */
class FileParser
{
    const MAX_FILE_SIZE = 52428800;

    /* @var array */
    private static $arLogLevelList = [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning',
        'notice',
        'info',
        'debug',
        'processed',
    ];

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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
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

        preg_match_all(RegexHelper::LOG_LARAVEL_FILE, $sFile, $arHeadings);
        if (empty($arHeadings) || empty(is_array($arHeadings))) {
            return $arResult;
        }

        $arLogData = preg_split(RegexHelper::LOG_LARAVEL_FILE, $sFile);
        if (Arr::get($arLogData, '0') < 1) {
            array_shift($arLogData);
        }

        foreach ($arHeadings as $sHead) {
            for ($iI = 0, $iJ = count($sHead); $iI < $iJ; $iI++) {
                foreach (static::$arLogLevelList as $sLevel) {
                    if (strpos(strtolower($sHead[$iI]), '.' . $sLevel) ||
                        strpos(strtolower($sHead[$iI]), $sLevel . ':')) {
                        preg_match(RegexHelper::LOG_LARAVEL_FILE_LEVEL['BEFORE'] . $sLevel . RegexHelper::LOG_LARAVEL_FILE_LEVEL['AFTER'], $sHead[$iI], $arCurrent);
                        if (empty(Arr::has($arCurrent, '4'))) {
                            continue;
                        }

                        $arResult[] = [
                            'context' => Arr::get($arCurrent, '3'),
                            'level'   => $sLevel,
                            'date'    => Arr::get($arCurrent, '1'),
                            'text'    => Arr::get($arCurrent, '4'),
                            'in_file' => Arr::get($arCurrent, '5'),
                            'stack'   => preg_replace(RegexHelper::LOG_LARAVEL_FILE_STACK, '', $arLogData[$iI]),
                        ];
                    }
                }
            }
        }

        rsort($arResult);

        return $arResult;
    }
}
