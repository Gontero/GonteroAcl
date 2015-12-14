<?php

namespace GonteroAcl\Listener;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\Application;
use Zend\Mvc\Router\RouteMatch;

use GonteroAcl\Annotation\Annotation;
use GonteroAcl\Authorized as AuthorizedInvokable;

class Authorized
{

    /**
     * @var RouteMatch
     */
    protected $routeMatch;

    /**
     * @var MvcEvent
     */
    protected $event;

    /**
     * @var type
     */
    protected $controllerName;

    /**
     * @var type
     */
    protected $methodName;

    /**
     * @var type
     */
    protected $application;

    /**
     * @var type
     */
    protected $controller;
    /**
     * @var User
     */
    protected $user;
    /**
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onDispach(MvcEvent $e)
    {
        $this->setEvent($e);

        $annotation = new Annotation();
        $annotation->setObject($this->getController());
        $annotation->setMethod($this->getMethodName());
        $roles = $annotation->getRoles();
        
        $auth = new AuthorizedInvokable(
            $e->getApplication()->getServiceManager()->get('AuthService')->getStorage()->read(),
            $roles
        );
        try {
            $auth();
        } catch (\Exception $ex) {
            $this->setUnauthorized($ex);
        }

    }

    protected function setUnauthorized($ex)
    {
        $this->getEvent()->setError(Application::ERROR_EXCEPTION)
            ->setController($this->getControllerName())
            ->setControllerClass(get_class($this->getController()))
            ->setParam('exception',$ex);

        $results = $this->getApplication()->getEventManager()->trigger(
            MvcEvent::EVENT_DISPATCH_ERROR,
            $this->getEvent()
        );

        $return  = $results->last();
        if (!$return) {
            $return = $this->getEvent()->getResult();
        }
        $this->getEvent()->setResult($return);
    }

    /**
     * @param \Zend\Mvc\MvcEvent $event
     */
    public function setEvent(MvcEvent $event)
    {
        $this->event = $event;
    }

    /**
     * @return MvcEvent
     * @throws \Exception
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @return \Zend\Mvc\Router\RouteMatch
     */
    public function getRouteMatch()
    {
        if (!$this->routeMatch) {
            $this->setRouteMatch($this->getEvent()->getRouteMatch());
        }
        return $this->routeMatch;
    }

    /**
     * @param \Zend\Mvc\Router\RouteMatch $routeMatch
     */
    public function setRouteMatch(RouteMatch $routeMatch)
    {
        $this->routeMatch = $routeMatch;
    }

    /**
     * @return string
     */
    public function getControllerName()
    {
        if (!$this->controllerName) {
            $this->setControllerName($this->getRouteMatch()->getParam('controller',
                    'not-found'));
        }
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return type
     */
    public function getMethodName()
    {
        if (!$this->methodName) {
            $action = $this->getRouteMatch()->getParam('action', 'not-found');
            $this->setMethodName(AbstractController::getMethodFromAction($action));
        }
        return $this->methodName;
    }

    /**
     * @param type $methodName
     */
    public function setMethodName($methodName)
    {
        $this->methodName = $methodName;
    }

    /**
     * @return Application
     */
    public function getApplication()
    {
        if (!$this->application) {
            $this->setApplication($this->getEvent()->getApplication());
        }
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @return type
     */
    public function getController()
    {
        if (!$this->controller) {
            $this->setController(
                $this->getApplication()
                    ->getServiceManager()
                    ->get('ControllerManager')
                    ->get($this->getControllerName())
            );
        }
        return $this->controller;
    }

    /**
     * @param type $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

}
