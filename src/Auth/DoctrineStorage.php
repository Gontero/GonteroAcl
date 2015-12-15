<?php

namespace GonteroAcl\Auth;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Storage;
use GonteroAcl\User\Entity\User;
use GonteroAcl\Options\ModuleOptionsAwareInterface;
use GonteroAcl\Options\ModuleOptions;

class DoctrineStorage extends Storage\Session implements ServiceLocatorAwareInterface, ModuleOptionsAwareInterface
{
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @return User
     */
    public function read()
    {
        if(!$this->session->{$this->member}) {
            return null;
        }
        return $this->serviceLocator
                ->get('Doctrine\ORM\EntityManager')
                ->getRepository($this->getModuleOptions()->getUserEntity())
                ->find($this->session->{$this->member});
    }

    /**
     * @param  User $contents
     * @return void
     */
    public function write($contents)
    {
        $this->session->{$this->member} = $contents->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->setModuleOptions($serviceLocator->get('GonteroAclOptions'));
    }

    /**
     * {@inheritdoc}
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * {@inheritdoc}
     */
    public function getModuleOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function setModuleOptions(ModuleOptions $options)
    {
        $this->options = $options;
    }
}