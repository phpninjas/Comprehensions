For Comprehensions
==================


Installation
============

composer.json
```javascript
{
  "require": {
    "phpninjas/comprehensions":"dev-master"
  }
}
```


Options
=======

```php
$option = Option("string")
$option->map(function($o){
  return strtoupper($o);
});

$option->get();
```