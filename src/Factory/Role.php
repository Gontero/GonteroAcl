<?php
namespace GonteroAcl\Factory;

use GonteroAcl\Model\Role as RoleModel;

class Role
{
    /**
     * @param string $name
     * @return \GonteroAcl\Model\RoleInterface
     */
    public static function factory($name)
    {
        return new RoleModel(strtolower($name));
    }
}