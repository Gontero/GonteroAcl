<?php

namespace GonteroAcl\Model;


class NoUser implements AclUser
{
    public function getRoles()
    {
        return array(
            \GonteroAcl\Factory\Role::factory('guest')
        );
    }
}