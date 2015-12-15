<?php

namespace GonteroAcl\Model;

class Role implements RoleInterface
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }
}