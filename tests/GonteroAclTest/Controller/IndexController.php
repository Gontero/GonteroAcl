<?php

namespace GonteroAclTest\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use GonteroAcl\Annotation\Role;

class IndexController extends AbstractActionController
{

    /**
     * @Role(roles={"guest"})
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * @Role(roles={"admin"})
     */
    public function adminAction()
    {
        return new ViewModel();
    }

    public function noRolesAction()
    {
        return new ViewModel();
    }

}
