<?php

namespace GonteroAcl\Annotation;

/**
 * @Annotation
 */
class Role
{
    private $roles;

    public function __construct($params)
    {
        $this->roles = array();
        foreach($params['roles'] as $roleName) {
            $this->roles[] = \GonteroAcl\Factory\Role::factory($roleName);
        }
    }

    public function getRoles() {
        return $this->roles;
    }
}