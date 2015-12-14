<?php
namespace GonteroAcl\Model;

interface AclUser
{
    /**
     * @return string[]
     */
    public function getRoles();
}