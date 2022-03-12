<?php namespace Falbar\SystemLog\Driver;

use Falbar\SystemLog\SystemLog;
use Illuminate\Support\Arr;

/**
 * Class AbstractDriver
 * @package Falbar\SystemLog\Driver
 */
abstract class AbstractDriver
{
    protected string $sNameSpace = SystemLog::NAMESPACE_DEFAULT;
    protected string $sType = SystemLog::TYPE_ERROR;
    protected string $sMessage = '';

    protected array $arContext = [
        'info' => [],
        'data' => [],
    ];

    /* @return $this */
    public function enableSimpleInfo(): self
    {
        $arTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $arTrace = Arr::get($arTrace, '0');
        if (empty($arTrace)) {
            return $this;
        }

        Arr::set($this->arContext, 'info', [
            'line' => Arr::get($arTrace, 'line'),
            'file' => Arr::get($arTrace, 'file'),
        ]);

        return $this;
    }

    /**
     * @param array $arInfo
     *
     * @return $this
     */
    public function setInfo(array $arInfo): self
    {
        $arContextInfo = (array)Arr::get($this->arContext, 'info');
        $arContextInfo = array_merge($arContextInfo, $arInfo);
        if (empty($arContextInfo)) {
            return $this;
        }

        Arr::set($this->arContext, 'info', $arContextInfo);

        return $this;
    }

    /**
     * @param string $sNameSpace
     *
     * @return $this
     */
    public function setNameSpace(string $sNameSpace): self
    {
        if (in_array($sNameSpace, SystemLog::NAMESPACE_AVAILABLE)) {
            $this->sNameSpace = $sNameSpace;
        }

        return $this;
    }

    /**
     * @param string $sMessage
     *
     * @return $this
     */
    public function setMessage(string $sMessage): self
    {
        $this->sMessage = $sMessage;

        return $this;
    }

    /**
     * @param array $arData
     *
     * @return $this
     */
    public function setData(array $arData): self
    {
        Arr::set($this->arContext, 'data', $arData);

        return $this;
    }

    /**
     * @param string $sType
     *
     * @return $this
     */
    public function setType(string $sType): self
    {
        if (in_array($sType, SystemLog::TYPE_AVAILABLE)) {
            $this->sType = $sType;
        }

        return $this;
    }
}
