<?php namespace Falbar\SystemLog\Driver\File;

use Falbar\SystemLog\InterfaceList\InterfaceGetAllSize;
use Falbar\SystemLog\InterfaceList\InterfaceDeleteAll;
use Falbar\SystemLog\InterfaceList\InterfaceGetList;
use Falbar\SystemLog\InterfaceList\InterfaceGetSize;
use Falbar\SystemLog\InterfaceList\InterfaceDelete;
use Falbar\SystemLog\SystemLog;

use Falbar\SystemLog\Helper\FileParser;
use Illuminate\Support\Facades\File;

/**
 * Class Read
 * @package Falbar\SystemLog\Driver\File
 */
class Read extends AbstractFile implements
    InterfaceGetSize,
    InterfaceGetAllSize,
    InterfaceGetList,
    InterfaceDelete,
    InterfaceDeleteAll
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
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
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

    /**
     * @param string $sNameSpace
     *
     * @return Read
     */
    public function setNameSpace(string $sNameSpace): self
    {
        $this->sNameSpace = $sNameSpace;

        return $this;
    }

    /* @return string */
    private function getStoragePath(): string
    {
        $sResult = '';

        switch ($this->sNameSpace) {
            case null;
                $sResult = storage_path(parent::BASE_DIR);
                break;
            case SystemLog::NAMESPACE_WEB:
            case SystemLog::NAMESPACE_API;
                $sResult = storage_path(parent::BASE_DIR . '/' . $this->sNameSpace);
                break;
        }

        return $sResult;
    }
}
