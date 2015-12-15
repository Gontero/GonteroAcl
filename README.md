## Annotation ACL plugin for Zend Framework 2

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
      'ZfAnnotation'
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
