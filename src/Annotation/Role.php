<?php

namespace GonteroAcl\Annotation;

use GonteroAcl\Model\RoleInterface;

/**
 * @Annotation
 */
class Role
{
    private $roles;

    /**
     * @param array $params
     */
    public function __construct($params)
    {
        $this->roles = array();
        foreach($params['roles'] as $roleName) {
            $this->roles[] = \GonteroAcl\Factory\Role::factory($roleName);
        }
    }

    /**
     * @return RoleInterface
     */
    public function getRoles() {
        return $this->roles;
    }
}