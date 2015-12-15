<?php

namespace GonteroAclTest\Annotation;

use GonteroAclTest\Controller\IndexController;
use GonteroAcl\Annotation\Annotation;
use PHPUnit_Framework_TestCase;

class AnnotationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var IndexController
     */
    protected $controller;

    protected function setUp()
    {
        $this->controller = new IndexController();
    }

    public function testNoRole()
    {
        $annotation = new Annotation();
        $annotation->setObject($this->controller);
        $annotation->setMethod('adminAction');
        $roles = $annotation->getRoles();
        
        $this->assertNotSame('guest', $roles[0]->getName());
    }

    public function testNoAction()
    {
        $annotation = new Annotation();
        $annotation->setObject($this->controller);
        $annotation->setMethod('fdsfdsfd');
        $roles = $annotation->getRoles();
        $this->assertSame('guest', $roles[0]->getName());
    }

    public function testHasRole()
    {
        $annotation = new Annotation();
        $annotation->setObject($this->controller);
        $annotation->setMethod('indexAction');
        $roles = $annotation->getRoles();
        $this->assertSame('guest', $roles[0]->getName());
    }

}