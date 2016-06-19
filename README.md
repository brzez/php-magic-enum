# php-magic-enum
Easy to use &amp; extend enum value objects for php

## Overview
PHP lacks enums. Everyone usually just uses const values, which don't really provide type safety, and can create messy code.

This might be a solution to this problem. It provides a enum value object. 

This magic enum can be instanced via magic methods (named the same as consts) which create new instances of the enum with value set to the consts value.

Example enum:
``` php
class OrderStatus extends \MagicEnum\MagicEnum
{
	const CREATED        = 1;
	const COMPLETE       = 2;
	const CANCELLED      = 3;
	const PROCESSING     = 4;

	// easy way to extend with the status (for labels/translations etc)
	public function getLabel()
	{
		$name = strtolower($this->getName());
		return "order_status.${name}";
	}
}
```

Usage:
``` php
// create new instance:
$status = OrderStatus::PROCESSING();
$status->getValue() // => 4

// type safety
public function setStatus(OrderStatus $status)
{
  $this->status = $status;
}
// safe setter (but less annoying)
public function setStatus($status)
{
  if($status instanceof OrderStatus){
    $this->status = $status;
  }else{
    $this->status = new OrderStatus($status); // this validates if $status is defined in OrderStatus const values
  }
}
```
Extras:
``` twig
{# it's easy to extend the enums with some additional features for example: #}
{{ order.status.label|trans }}
```

## todo:
- [ ] Add to packagist
- [ ] Write help for installation via composer
- [ ] Write some more usage help

