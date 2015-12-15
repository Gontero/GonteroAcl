<?php

namespace GonteroAcl\Auth;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;
use Zend\Crypt\Password\Bcrypt;
use GonteroAcl\Options\ModuleOptionsAwareInterface;
use GonteroAcl\Options\ModuleOptions;

class DoctrineAdapter extends AbstractAdapter implements ServiceLocatorAwareInterface, ModuleOptionsAwareInterface
{
    protected $repository;
    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * {@inheritdoc}
     */
    public function authenticate()
    {
        $users = $this->repository->findBy(array('email' => $this->getIdentity()));

        if (empty($users)) {
            return new AuthenticationResult(
                AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND, null,
                array('Authentication failure.')
            );
        }

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->options->getBCryptCost());

        foreach ($users as $user) {
            if ($bcrypt->verify($this->getCredential(), $user->getPassword())) {
                return new AuthenticationResult(
                    AuthenticationResult::SUCCESS, $user,
                    array('Authentication successful.')
                );
            }
        }

        return new AuthenticationResult(
            AuthenticationResult::FAILURE_CREDENTIAL_INVALID, null,
            array('Authentication failure.')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        $this->setModuleOptions($serviceLocator->get('GonteroAclOptions'));
        
        $this->repository = $serviceLocator
            ->get('Doctrine\ORM\EntityManager')
            ->getRepository($this->getModuleOptions()->getUserEntity());
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