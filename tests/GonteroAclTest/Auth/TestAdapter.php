<?php
namespace GonteroAclTest\Auth;

use Zend\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;

class TestAdapter extends AbstractAdapter
{
    /**
     * {@inheritdoc}
     */
    public function authenticate()
    {
        if($this->getIdentity() == 1) {
            return new AuthenticationResult(
                AuthenticationResult::SUCCESS,
                new \GonteroAclTest\Entity\User(array('admin')),
                array('Authentication successful.')
            );
        }

        if($this->getIdentity() == 2) {
            return new AuthenticationResult(
                AuthenticationResult::SUCCESS,
                new \GonteroAclTest\Entity\User(array('user')),
                array('Authentication successful.')
            );
        }

        return new AuthenticationResult(
            AuthenticationResult::FAILURE_IDENTITY_NOT_FOUND,
            null,
            array('Authentication failure.')
        );
    }
    
}