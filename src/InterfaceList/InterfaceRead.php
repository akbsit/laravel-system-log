<?php namespace Falbar\SystemLog\InterfaceList;

use Falbar\SystemLog\InterfaceList\Read\InterfaceGetAllSize;
use Falbar\SystemLog\InterfaceList\Read\InterfaceDeleteAll;
use Falbar\SystemLog\InterfaceList\Read\InterfaceGetList;
use Falbar\SystemLog\InterfaceList\Read\InterfaceGetSize;
use Falbar\SystemLog\InterfaceList\Read\InterfaceDelete;

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
     * @return $this
     */
    public function setNameSpace(string $sNameSpace);
}
