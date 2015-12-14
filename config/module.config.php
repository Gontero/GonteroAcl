<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'AuthService' => \GonteroAcl\Auth\AuthServiceFactory::class,
        ),
        'invokables' => array(
            'acl_listener' => \GonteroAcl\Listener\Authorized::class,
        ),
    ),
);
