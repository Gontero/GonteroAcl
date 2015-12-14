<?php

namespace GonteroAclTest\Annotation;

use GonteroAcl\Authorized;
use GonteroAcl\Factory\Role;
use GonteroAclTest\Entity\User;
use GonteroAcl\Exception\UnathorizedException;
use PHPUnit_Framework_TestCase;

class AuthorizedTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {

    }

    public function testNoUserNoRole()
    {
        $auth = new Authorized();
        $this->assertTrue($auth());
    }

    public function testUserHasRole()
    {
        
        $user = new User(array(
            Role::factory('guest'),
            Role::factory('user')
        ));
        $auth = new Authorized($user);
        $this->assertTrue($auth());

    }

    public function testUserHasNotRole()
    {
        $this->setExpectedException(UnathorizedException::class);

        $user = new User(array(Role::factory('guest')));
        $auth = new Authorized($user,array(Role::factory('user')));
        $auth();
    }

}