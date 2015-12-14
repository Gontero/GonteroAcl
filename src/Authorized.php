<?php
namespace GonteroAcl;

use GonteroAcl\Model\AclUser;
use GonteroAcl\Model\Role;
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
            $this->roles = [new Role\Guest()];
        } else {
            $this->roles = $roles;
        }
        
    }

    public function __invoke()
    {
        $intersec = array_intersect($this->getUser()->getRoles(),$this->getRoles());
        if(empty($intersec)) {
            throw new UnathorizedException();
        }
        return true;
    }

    /**
     * @return AclUser
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string[]
     */
    public function getRoles()
    {
        return $this->roles;
    }

}