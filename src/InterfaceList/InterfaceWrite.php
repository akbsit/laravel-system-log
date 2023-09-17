<?php namespace Akbsit\SystemLog\InterfaceList;

use Akbsit\SystemLog\InterfaceList\Write\InterfacePut;

/**
 * Interface InterfaceWrite
 * @package Akbsit\SystemLog\InterfaceList
 */
interface InterfaceWrite extends InterfacePut
{
    /* @return $this */
    public function enableSimpleInfo();

    /**
     * @param array $arInfo
     *
     * @return $this
     */
    public function setInfo(array $arInfo);

    /**
     * @param string $sNameSpace
     *
     * @return $this
     */
    public function setNameSpace(string $sNameSpace);

    /**
     * @param string $sMessage
     *
     * @return $this
     */
    public function setMessage(string $sMessage);

    /**
     * @param array $arData
     *
     * @return $this
     */
    public function setData(array $arData);

    /**
     * @param string $sType
     *
     * @return $this
     */
    public function setType(string $sType);
}
