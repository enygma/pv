pv: php objects

The pv project is an experiment in trying to make strongly-typed objects for PHP. There are
currently five types of objects in the set, some which mimic PHP's current variables:

- PArray
- PBoolean
- PDate
- PObject
- PString

Each of these methods allow you to specify validation methods to check the contents of
the variable. These can be run by calling the `validate` method at any time. They can also
be added or removed as needed.

The variables also allow for conversion between the types (a more structured method than
PHP's loose typing). When the types are converted, a "to" method is executed when the
`convert` method is called.


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

Executing a Single Validator:
=========================

If you have validation that you want to execute but don't want to add it to the set, you
can execute a single validation with the `single` method:

```php
<?php
$str = new Pv\PString('testing');
$str->single('length[1,3]');
?>
```

In this case, the validation fails so a `ValidationException` will be immediately thrown.

Additionally, since the `single` call returns the current object so you can chain `single`
calls:

```php
<?php
$str = new Pv\PString('me@me.com');
$str->single('length[1,10]')->single('email');
?>
```

The above example would pass validation and not throw an exception.

Validation with Closures:
=========================

You can also specify a closure to that returns either a `true` or `false` value to allow
for custom validation:

```php
<?php
$str = '12345678';
$s = new \Pv\PString($str);

var_export( $s->addValidation(function($value) { return false; }) );
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
