## Annotation ACL plugin for Zend Framework 2

This plugin is create for manage ACL with zend annotations engine. It looks like this:

```
use GonterAcl\Annotation\Role;

class IndexController extends AbstractActionController
{

  /**
   * here u can pass roles in annotations wich users can use this action.
   * @Role(roles={"guest","user","admin"})
   */
  public function indexAction()
  {
    return;
  }
}
```

### Requirements

> PHP >= 5.5.0

## Installation

### Require via composer

> composer require gontero/gontero-acl

### Enable it in application.config.php

```
return array(
  'modules' => array(
      // other modules
      'GonteroAcl'
  ),
  // other content
);
```

### Configuration:

```
array(
  'GonteroAcl' => array(
  )
)
```
