<?php namespace Falbar\SystemLog\Driver\File;

use Falbar\SystemLog\InterfaceList\InterfaceRead;
use Falbar\SystemLog\Helper\FileParser;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

/**
 * Class Read
 * @package Falbar\SystemLog\Driver\File
 */
class Read extends AbstractFile implements InterfaceRead
{
    /* @return int */
    public function getSize(): int
    {
        $iResult = 0;

        $sStoragePath = $this->getStoragePath();
        if (empty($sStoragePath) || empty(File::exists($sStoragePath))) {
            return $iResult;
        }

        $arFileList = File::files($sStoragePath);
        if (empty($arFileList)) {
            return $iResult;
        }

        foreach ($arFileList as $oFile) {
            $iResult += $oFile->getSize();
        }

        return $iResult;
    }

    /**
     * @return array
     *
     * @throws FileNotFoundException
     */
    public function getList(): array
    {
        $arResult = [];

        $sStoragePath = $this->getStoragePath();
        if (empty($sStoragePath) || empty(File::exists($sStoragePath))) {
            return $arResult;
        }

        $arFileList = File::files($sStoragePath);
        if (empty($arFileList)) {
            return $arResult;
        }

        foreach ($arFileList as $oFile) {
            FileParser::setFile($oFile);

            $arResult[] = [
                'name' => $oFile->getBasename(),
                'size' => $oFile->getSize(),
                'list' => FileParser::getAll(),
            ];

            FileParser::clearFile();
        }

        rsort($arResult);

        return $arResult;
    }

    /* @return int */
    public function getAllSize(): int
    {
        $iResult = 0;

        $sStoragePath = $this->getStoragePath();
        if (empty($sStoragePath) || empty(File::exists($sStoragePath))) {
            return $iResult;
        }

        $arFileList = File::allFiles($sStoragePath);
        if (empty($arFileList)) {
            return $iResult;
        }

        foreach ($arFileList as $oFile) {
            $iResult += $oFile->getSize();
        }

        return $iResult;
    }

    /* @return bool */
    public function delete(): bool
    {
        $sStoragePath = $this->getStoragePath();
        if (empty($sStoragePath) || empty(File::exists($sStoragePath))) {
            return false;
        }

        $arFileList = File::files($sStoragePath);
        if (empty($arFileList)) {
            return true;
        }

        foreach ($arFileList as $oFile) {
            File::delete($oFile->getRealPath());
        }

        return true;
    }

    /* @return bool */
    public function deleteAll(): bool
    {
        $sStoragePath = $this->getStoragePath();
        if (empty($sStoragePath) || empty(File::exists($sStoragePath))) {
            return false;
        }

        $arFileList = File::allFiles($sStoragePath);
        if (empty($arFileList)) {
            return true;
        }

        foreach ($arFileList as $oFile) {
            File::delete($oFile->getRealPath());
        }

        return true;
    }
}
