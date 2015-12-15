<?php

namespace GonteroAcl\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;

    /**
     * @var string
     */
    protected $userEntity = '';

    /**
     * @var int
     */
    protected $bCryptCost = 4;
    
    public function getUserEntity()
    {
        return $this->userEntity;
    }

    public function setUserEntity($userEntity)
    {
        $this->userEntity = $userEntity;
    }

    public function getBCryptCost()
    {
        return $this->bCryptCost;
    }

    public function setBCryptCost($bCryptCost)
    {
        $this->bCryptCost = $bCryptCost;
    }
}