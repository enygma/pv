pv: simple PHP validation

[![Build Status](https://secure.travis-ci.org/enygma/pv.png?branch=master)](http://travis-ci.org/enygma/pv)

Example usage:
=======================

```php
<?php

### String example
$str = '12345678901';
$s = new Pv\PString($str, array('length[1,10]','numeric'));

// since our string is numeric but is longer than 10 characters
echo 'RESULT: '; var_dump($s->validate()); echo "\n\n"; // false

### Array example
$str = array('test' => 'foo');
$s1 = new Pv\PArray($str, array('length[1]'));

echo 'RESULT: '; var_dump($s1->validate()); echo "\n\n"; // true

### Object example
$obj = new stdClass();
$obj->foo = 'bar';

$s2 = new Pv\PObject($obj, array('hasproperty[foo]'));

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

```php
<?php
$str = '12345678901';
$s = new Pv\PString($str, array('not:length[1,10]'));
?>
```

The above returns `true` because the string of numbers is longer than 10 characters.

Naming Validators:
=========================

When you assign your validation, you can give them unique naming for reference later:

```php
<?php
$str = '12345678901';
$s = new Pv\PString($str, array(
    'validate1' => 'not:length[1,10]'
));

// or you can set it with addValidate
$s->addValidation('not:length[1,10]','validate1');
?>
```

You can also remove them with the same name:

```php
<?php
$str = '12345678901';
$s = new Pv\PString($str, array(
    'validate1' => 'not:length[1,10]'
));
$s->removeValidation('validate1');
// you can also just use a numeric index here too
?>
```

Executing Certain Validators
=========================

If there's more than one validator on an object, you have the choice of executing all
of the validators (default behavior), or you can execute a single validator:

```php
<?php
$str = '12345';
$s = new Pv\PString($str, array('length[10,12]', 'numeric'));

var_export($s->validate(0)); // fails
var_export($s->validate(1)); // passes
?>
```

This also works with named validators as well:

```php
<?php
var_export($s->validate('validate1'));
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

Converting between types:
=========================

The objects allow you to convert between types easily. PHP does native type jugging, but
the results can sometimes be unpredictable. Each object has methods to convert to the 
other types. Here's an example:

```php
<?php

$init = true;
$bool = new \Pv\PBoolean($init);
$ret  = $bool->convert('string');

var_export($ret); // outputs the string "true"

?>
```

Current Validators:
=========================

**String:**

- *length[min,max]:* Check to be sure the string's length is between min/max

- *int:* Check to see if the string is an integer

- *numeric:* Check to see if the string is numeric

- *url:* See if the string validates as a URL
 
- *range[min,max]:* Checks to see if the value is in a given range

- *contains[find]:* "Find" is a substring in the value

**Array:**

- *length[min,max]:* Check to be sure an array's length is between the min/max

- *contains[find]:* "Find" is a value in the array

**Object:**

- *hasproperty[name]:* Check to see if object has a property

- *instance[class name]:* Check to see if object is an instance of the class name

**Boolean:**

- None

**Date:**

- *between[start,end]:* Check to see if the date is between the start/end dates

@author Chris Cornutt <ccornutt@phpdeveloper.org>

@license MIT
