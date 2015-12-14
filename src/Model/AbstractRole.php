<?php

namespace GonteroAcl\Model;

class AbstractRole {

    protected static $role;

    public function getName() {
        return static::$role;
    }

    public function __toString()
    {
        return $this->getName();
    }
    
}