<?php
namespace GonteroAcl;

use GonteroAcl\Model\AclUser;
use GonteroAcl\Factory\Role;
use GonteroAcl\Model\NoUser;
use GonteroAcl\Exception\UnathorizedException;

class Authorized
{

    /**
     * @var AclUser
     */
    protected $user;

    /**
     * @var string[]
     */
    protected $roles;

    public function __construct(AclUser $user = null, $roles = array())
    {
        if(!$user) {
            $this->user = new NoUser;
        } else {
            $this->user = $user;
        }
        if(empty($roles)) {
            $this->roles = [Role::factory('guest')];
        } else {
            $this->roles = $roles;
        }
        
    }

    public function __invoke()
    {
        foreach ($this->getUser()->getRoles() as $userRole) {
            foreach ($this->getRoles() as $actionRole) {
                if(strtolower($userRole->getName()) == strtolower($actionRole->getName())) {
                    return true;
                }
            }
        }
        throw new UnathorizedException();
    }

    /**
     * @return AclUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \GonteroAcl\Model\RoleInterface[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

}