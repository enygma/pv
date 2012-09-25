pv: simple PHP validation

Example usage:
=======================

```php
<?php

### String example
$str = '12345678901';
$s = new Pv\PString($str,array('length[1,10]','numeric'));

// since our string is numeric but is longer than 10 characters
echo 'RESULT: '; var_dump($s->validate()); echo "\n\n"; // false

### Array example
$str = array('test' => 'foo');
$s1 = new Pv\PArray($str,array('length[1]'));

echo 'RESULT: '; var_dump($s1->validate()); echo "\n\n"; // true

### Object example
$obj = new stdClass();
$obj->foo = 'bar';

$s2 = new Pv\PObject($obj,array('hasproperty[foo]'));

echo 'RESULT: '; var_dump($s2->validate()); echo "\n\n"; // true
?>
```

Current Validators:
=========================

**String:**
*length([min],[max]):* Check to be sure the string's length is between min/max
*int:* Check to see if the string is an integer
*numeric:* Check to see if the string is numeric
*url:* See if the string validates as a URL

**Array:**
*length([min],[max]):* Check to be sure an array's length is between the min/max

**Object:**
*hasproperty([name]):* Check to see if object has a property