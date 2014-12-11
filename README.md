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

Imagine if you're using Doctrine, and you don't know if attempting to find an object by id will result in an object or a 
null value. Thus you might want to wrap the object into an option. It will either be Some[DbObject] or None.
However, you can still perform mapping operations on it as if it were going to be a DbObject.
Thus you negate the need for null checks.

```php
$product = $entityManager->find('Product', "some identifier");

if ($product === null) {
    return $product->getName();   
}
return "";
```
becomes
```php
$product = Option($entityManager->find('Product', "some identifier"));
$name = $product->map(function($p){
  return $p->getName();
});

return $name->getOrElse("");
```