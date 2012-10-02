pv: simple PHP validation

[![Build Status](https://secure.travis-ci.org/enygma/pv.png?branch=master)](http://travis-ci.org/enygma/pv)

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

### Boolean example
$s3 = new Pv\PBoolean(true);

## Adding more validation
$str = '12345678901';
$s = new Pv\PString($str,array('length[1,10]'));
$s->addValidation('numeric');

// since our string is numeric but is longer than 10 characters
echo 'RESULT: '; var_dump($s->validate()); echo "\n\n"; // false

?>
```

Negation:
=========================

You can negate any check by adding a "not:" before it. For example:

```
<?php
$str = '12345678901';
$s = new Pv\PString($str,array('not:length[1,10]'));
?>
```

The above returns `true` because the string of numbers is longer than 10 characters.

Naming Validators:
=========================

When you assign your validation, you can give them unique naming for reference later:

```
<?php
$str = '12345678901';
$s = new Pv\PString($str,array(
    'validate1' => 'not:length[1,10]'
));

// or you can set it with addValidate
$s->addValidation('not:length[1,10]','validate1');
?>
```

You can also remove them with the same name:

```
<?php
$str = '12345678901';
$s = new Pv\PString($str,array(
    'validate1' => 'not:length[1,10]'
));
$s->removeValidation('validate1');
// you can also just use a numeric index here too
?>
```

Catching Exceptions:
=========================

## Creation
When you create a new object, if the data given doesn't match the type for the object,
you'll be thrown a `ValidationException`.

## Validation

When the `validate()` call fails, you'll be thrown an exception, a `ValidationException`.
You can catch this just like any other exception and find out what validation failed:

```php
<?php

try {
    $s2->validate();
} catch(\Exception $e) {
    echo 'ERROR: '.$e->getMessage();
    // Output: "Failure on validation Pv\Validate\Length"
}

?>
```

Current Validators:
=========================

**String:**

- *length([min],[max]):* Check to be sure the string's length is between min/max

- *int:* Check to see if the string is an integer

- *numeric:* Check to see if the string is numeric

- *url:* See if the string validates as a URL
 
- *range([min],[max]):* Checks to see if the value is in a given range

**Array:**

- *length([min],[max]):* Check to be sure an array's length is between the min/max

**Object:**

- *hasproperty([name]):* Check to see if object has a property

- *instance([class name]):* Check to see if object is an instance of the class name

**Boolean:**

- None

@author Chris Cornutt <ccornutt@phpdveloper.org>

@license MIT
