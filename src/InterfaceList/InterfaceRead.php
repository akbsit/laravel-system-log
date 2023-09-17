<?php namespace Akbsit\SystemLog\InterfaceList;

use Akbsit\SystemLog\InterfaceList\Read\InterfaceGetAllSize;
use Akbsit\SystemLog\InterfaceList\Read\InterfaceDeleteAll;
use Akbsit\SystemLog\InterfaceList\Read\InterfaceGetList;
use Akbsit\SystemLog\InterfaceList\Read\InterfaceGetSize;
use Akbsit\SystemLog\InterfaceList\Read\InterfaceDelete;

/**
 * Interface InterfaceRead
 * @package Akbsit\SystemLog\InterfaceList
 */
interface InterfaceRead extends
    InterfaceGetAllSize,
    InterfaceDeleteAll,
    InterfaceGetList,
    InterfaceGetSize,
    InterfaceDelete
{
    /**
     * @param string $sNameSpace
     *
     * @return $this
     */
    public function setNameSpace(string $sNameSpace);
}
