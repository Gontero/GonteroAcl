<?php

namespace GonteroAclTest\Annotation;

use GonteroAcl\Listener\Authorized;
use GonteroAcl\Exception\UnathorizedException;
use GonteroAclTest\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use GonteroAclTest\Controller\IndexController;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage;
use GonteroAclTest\Auth\TestAdapter;

class AuthorizedListenerTest extends PHPUnit_Framework_TestCase
{
    /** @var IndexController */
    protected $controller;

    /** @var Request */
    protected $request;

    /** @var Response */
    protected $response;

    /** @var RouteMatch */
    protected $routeMatch;

    /** @var MvcEvent */
    protected $event;

    protected function setUp()
    {
        $serviceManager   = Bootstrap::getServiceManager();
        $this->controller = new IndexController();
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'index'));
        $this->event      = new MvcEvent();
        $config           = $serviceManager->get('Config');
        $routerConfig     = isset($config['router']) ? $config['router'] : array();
        $router           = HttpRouter::factory($routerConfig);

        $serviceManager->setAllowOverride(true);

        $serviceManager->setService('AuthService',
            new AuthenticationService(
                new Storage\NonPersistent(), new TestAdapter()
        ));

        $albumTableMock = $this->getMockBuilder('Zend\Mvc\Controller\ControllerManager')
            ->disableOriginalConstructor()
            ->getMock();

        $albumTableMock->expects($this->any())
            ->method('get')
            ->will($this->returnValue($this->controller));
        
        $serviceManager->setService('ControllerManager', $albumTableMock);

        $this->event->setApplication(new Application($config, $serviceManager));
        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    public function testUserDontAllowed()
    {
        $this->routeMatch->setParam('action', 'admin');

        $listener = new Authorized();
        $listener->setController($this->controller);
        $listener->onDispach($this->event);
        $this->assertInstanceOf(UnathorizedException::class,
            $this->event->getParam('exception'));
    }

    public function testUserAllowed()
    {

        $this->routeMatch->setParam('action', 'index');

        $listener = new Authorized();
        $listener->setController($this->controller);
        $listener->onDispach($this->event);
        $this->assertNull($this->event->getParam('exception'));
    }

    public function testNoRolesAllowed()
    {

        $this->routeMatch->setParam('action', 'noRoles');

        $listener = new Authorized();
        $listener->onDispach($this->event);
        $this->assertNull($this->event->getParam('exception'));
    }
}