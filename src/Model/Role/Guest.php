<?php
namespace GonteroAcl\Model\Role;

use GonteroAcl\Model\AbstractRole;

class Guest extends AbstractRole
{
    protected static $role = 'user';
}