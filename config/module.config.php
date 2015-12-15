<?php

return array(
    'view_helpers' => array(
        'factories'=> array(
            'userIdentity' => function ($sm) {
                $serviceLocator = $sm->getServiceLocator();
                $viewHelper = new \GonteroAcl\Auth\View\Helper\UserIdentity;
                $viewHelper->setAuthService($serviceLocator->get('AuthService'));
                return $viewHelper;
            },
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'AuthService' => function ($sm) {
                return new AuthenticationService(
                    $sm->get('AuthStorage'),
                    $sm->get('AuthAdapter')
                );
            },
            'GonteroAclOptions' => function ($sm) {
                $config = $sm->get('Config');
                return new \GonteroAcl\Options\ModuleOptions(
                    isset($config['gontero-acl']) ? $config['gontero-acl'] : array()
                );
            },
        ),
        'invokables' => array(
            'GonteroAclListener' => \GonteroAcl\Listener\Authorized::class,
            'AuthStorage' => \GonteroAcl\Auth\DoctrineStorage::class,
            'AuthAdapter' => \GonteroAcl\Auth\DoctrineAdapter::class,
        ),
    ),
);
