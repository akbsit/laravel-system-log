<?php namespace Falbar\SystemLog\InterfaceList;

use Falbar\SystemLog\InterfaceList\Read\InterfaceGetAllSize;
use Falbar\SystemLog\InterfaceList\Read\InterfaceDeleteAll;
use Falbar\SystemLog\InterfaceList\Read\InterfaceGetList;
use Falbar\SystemLog\InterfaceList\Read\InterfaceGetSize;
use Falbar\SystemLog\InterfaceList\Read\InterfaceDelete;

use Falbar\SystemLog\Driver\AbstractDriver;

/**
 * Interface InterfaceRead
 * @package Falbar\SystemLog\InterfaceList
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
     * @return AbstractDriver
     */
    public function setNameSpace(string $sNameSpace): AbstractDriver;
}
