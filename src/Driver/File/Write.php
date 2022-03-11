<?php namespace Falbar\SystemLog\Driver\File;

use Falbar\SystemLog\InterfaceList\InterfacePut;
use Falbar\SystemLog\SystemLog;

use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Exception;

/**
 * Class Write
 * @package Falbar\SystemLog\Driver\File
 */
class Write extends AbstractFile implements InterfacePut
{
    const DIR_MODE = 0777;

    private string $sType;
    private string $sMessage;

    private array $arContext;

    /**
     * Write constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->arContext = [
            'info' => [],
            'data' => [],
        ];
        $this->sMessage = '';

        if (empty($this->sType)) {
            $this->sType = SystemLog::ERROR;
        }

        if (empty($this->sNameSpace)) {
            $this->sNameSpace = SystemLog::NAMESPACE_API;
        }
    }

    /* @return bool */
    public function put(): bool
    {
        $bResult = false;

        $sBaseDirPath = storage_path(parent::BASE_DIR);
        $sLogDirPath = $sBaseDirPath . '/' . $this->sNameSpace;

        try {
            if (empty(File::isDirectory($sLogDirPath))) {
                File::makeDirectory($sLogDirPath, self::DIR_MODE, true, true);
            }

            $sLogLine = '[' . Carbon::now()->toDateTimeString() . ']';
            $sLogLine .= ' ' . $this->sType . ':';
            $sLogLine .= ' ' . $this->sMessage;

            if ($this->arContext['info'] || $this->arContext['data']) {
                $sLogLine .= ' ' . json_encode($this->arContext, JSON_UNESCAPED_UNICODE);
            }

            $sLogLine .= PHP_EOL;

            if (File::append($sLogDirPath . '/' . $this->sNameSpace . '-' . date('Y-m-d') . '.log', $sLogLine)) {
                $bResult = true;
            }
        } catch (Exception $oException) {
            return $bResult;
        }

        return $bResult;
    }

    /**
     * @param string $sMessage
     *
     * @return Write
     */
    public function setMessage(string $sMessage): self
    {
        $this->sMessage = $sMessage;

        return $this;
    }

    /**
     * @param array $arInfo
     *
     * @return Write
     */
    public function setInfo(array $arInfo): self
    {
        $this->arContext['info'] = $arInfo;

        return $this;
    }

    /**
     * @param array $arData
     *
     * @return Write
     */
    public function setData(array $arData): self
    {
        $this->arContext['data'] = $arData;

        return $this;
    }

    /**
     * @param string $sType
     *
     * @return Write
     */
    public function setType(string $sType): self
    {
        $this->sType = $sType;

        return $this;
    }

    /**
     * @param string $sNameSpace
     *
     * @return Write
     */
    public function setNameSpace(string $sNameSpace): self
    {
        $this->sNameSpace = $sNameSpace;

        return $this;
    }
}
