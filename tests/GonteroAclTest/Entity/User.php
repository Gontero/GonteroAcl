<?php
namespace GonteroAclTest\Entity;

use GonteroAcl\Model\AclUser;

class User implements AclUser
{
    protected $roles;

    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    public function getRoles()
    {
        return $this->roles;
    }
}