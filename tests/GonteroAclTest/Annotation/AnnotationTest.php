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
        $this->assertNotInstanceOf(\GonteroAcl\Model\Role\Guest::class, $roles[0]);
    }

    public function testNoAction()
    {
        $annotation = new Annotation();
        $annotation->setObject($this->controller);
        $annotation->setMethod('fdsfdsfd');
        $roles = $annotation->getRoles();
        $this->assertInstanceOf(\GonteroAcl\Model\Role\Guest::class, $roles[0]);
    }

    public function testHasRole()
    {
        $annotation = new Annotation();
        $annotation->setObject($this->controller);
        $annotation->setMethod('indexAction');
        $roles = $annotation->getRoles();
        $this->assertInstanceOf(\GonteroAcl\Model\Role\Guest::class, $roles[0]);
    }

}