<?php
namespace GonteroAcl\Factory;

use GonteroAcl\Model\Role as RoleNameSpace;

class Role
{
    public static function factory($name)
    {
        switch (strtolower($name)) {
            case 'admin':
                $role = new RoleNameSpace\Admin();
                break;
            case 'user':
                $role = new RoleNameSpace\User();
                break;
            default :
                $role = new RoleNameSpace\Guest();
                break;
        }
        return $role;
    }
}