<?php

namespace GonteroAcl\Annotation;

use Zend\Code\Annotation\AnnotationCollection;
use Zend\Code\Annotation\AnnotationManager;
use Zend\Code\Annotation\Parser;
use Zend\Code\Reflection\ClassReflection;

use GonteroAcl\Model\Role\Guest;

class Annotation
{
    /**
     * @var Parser\DoctrineAnnotationParser
     */
    protected $annotationParser;

    /**
     * @var AnnotationManager
     */
    protected $annotationManager;

    /**
     * @var array Default annotations to register
     */
    protected $defaultAnnotations = array(
        'Role'
    );
    
    /**
     * object for get annotation
     * 
     * @var mixed
     */
    protected $object;

    /**
     * name of method for take annotations
     * 
     * @var string
     */
    protected $method;

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = array(new Guest());
        if ($this->getAnnotations() instanceof AnnotationCollection) {
            foreach ($this->getAnnotations() as $annotation) {
                if ($annotation instanceof Role) {
                    $roles = $annotation->getRoles();
                }
            }
        }
        return $roles;
    }

    /**
     * @return AnnotationCollection
     */
    public function getAnnotations()
    {
        $reflection = new ClassReflection($this->getObject());
        try {
            $reflectionMethod = $reflection->getMethod($this->getMethod());
            return $reflectionMethod->getAnnotations($this->getAnnotationManager());
        } catch (\ReflectionException $e) {
            return false;
        }
    }
    
    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * Retrieve annotation manager
     *
     * If none is currently set, creates one with default annotations.
     *
     * @return AnnotationManager
     */
    public function getAnnotationManager()
    {
        if ($this->annotationManager) {
            return $this->annotationManager;
        }

        $this->setAnnotationManager(new AnnotationManager());
        return $this->annotationManager;
    }

    /**
     * Set annotation manager to use when building form from annotations
     *
     * @param  AnnotationManager $annotationManager
     * @return AnnotationBuilder
     */
    public function setAnnotationManager(AnnotationManager $annotationManager)
    {
        $parser = $this->getAnnotationParser();
        foreach ($this->defaultAnnotations as $annotationName) {
            $class = __NAMESPACE__.'\\'.$annotationName;
            $parser->registerAnnotation($class);
        }
        $annotationManager->attach($parser);
        $this->annotationManager = $annotationManager;
        return $this;
    }

    /**
     * @return \Zend\Code\Annotation\Parser\DoctrineAnnotationParser
     */
    public function getAnnotationParser()
    {
        if (null === $this->annotationParser) {
            $this->annotationParser = new Parser\DoctrineAnnotationParser();
        }

        return $this->annotationParser;
    }

}