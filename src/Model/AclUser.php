<?php
namespace GonteroAcl\Model;

interface AclUser
{
    /**
     * @return \GonteroAcl\Model\RoleInterface[]
     */
    public function getRoles();

    /**
     * @return string
     */
    public function getEmail();
    
    /**
     * @return string
     */
    public function getPassword();
}