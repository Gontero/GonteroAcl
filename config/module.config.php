<?php

use Zend\Authentication\AuthenticationService;
use GonteroAcl\Auth\View\Helper\UserIdentity;
use GonteroAcl\Options\ModuleOptions;
use GonteroAcl\Listener\Authorized;
use GonteroAcl\Auth\DoctrineAdapter;
use GonteroAcl\Auth\DoctrineStorage;

return array(
    'view_helpers' => array(
        'factories' => array(
            'userIdentity' => function ($sm) {
                $serviceLocator = $sm->getServiceLocator();
                $viewHelper     = new UserIdentity;
                $viewHelper->setAuthService($serviceLocator->get('AuthService'));
                return $viewHelper;
            },
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'AuthService' => function ($sm) {
                return new AuthenticationService(
                    $sm->get('AuthStorage'), $sm->get('AuthAdapter')
                );
            },
            'GonteroAclOptions' => function ($sm) {
                $config = $sm->get('Config');
                return new ModuleOptions(
                    isset($config['gontero-acl']) ? $config['gontero-acl'] : array()
                );
            },
            ),
            'invokables' => array(
                'GonteroAclListener' => Authorized::class,
                'AuthStorage' => DoctrineStorage::class,
                'AuthAdapter' => DoctrineAdapter::class,
            ),
        ),
    );
