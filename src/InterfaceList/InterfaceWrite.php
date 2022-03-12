<?php namespace Falbar\SystemLog\InterfaceList;

use Falbar\SystemLog\InterfaceList\Write\InterfacePut;
use Falbar\SystemLog\Driver\AbstractDriver;

/**
 * Interface InterfaceWrite
 * @package Falbar\SystemLog\InterfaceList
 */
interface InterfaceWrite extends InterfacePut
{
    /* @return AbstractDriver */
    public function enableSimpleInfo(): AbstractDriver;

    /**
     * @param array $arInfo
     *
     * @return AbstractDriver
     */
    public function setInfo(array $arInfo): AbstractDriver;

    /**
     * @param string $sNameSpace
     *
     * @return AbstractDriver
     */
    public function setNameSpace(string $sNameSpace): AbstractDriver;

    /**
     * @param string $sMessage
     *
     * @return AbstractDriver
     */
    public function setMessage(string $sMessage): AbstractDriver;

    /**
     * @param array $arData
     *
     * @return AbstractDriver
     */
    public function setData(array $arData): AbstractDriver;

    /**
     * @param string $sType
     *
     * @return AbstractDriver
     */
    public function setType(string $sType): AbstractDriver;
}
