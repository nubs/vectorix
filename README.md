# vectorix
A PHP vector library.

[![Build Status](https://travis-ci.org/nubs/vectorix.png)](https://travis-ci.org/nubs/vectorix)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nubs/vectorix/badges/quality-score.png?s=305d0004eead29ac31293b70fc1d16a1ec7cb7ed)](https://scrutinizer-ci.com/g/nubs/vectorix/)
[![Code Coverage](https://scrutinizer-ci.com/g/nubs/vectorix/badges/coverage.png?s=489bd6b9bb29932c9d3e551b23cfb267c9ccf102)](https://scrutinizer-ci.com/g/nubs/vectorix/)

[![Latest Stable Version](https://poser.pugx.org/nubs/vectorix/v/stable.png)](https://packagist.org/packages/nubs/vectorix)
[![Total Downloads](https://poser.pugx.org/nubs/vectorix/downloads.png)](https://packagist.org/packages/nubs/vectorix)
[![Latest Unstable Version](https://poser.pugx.org/nubs/vectorix/v/unstable.png)](https://packagist.org/packages/nubs/vectorix)
[![License](https://poser.pugx.org/nubs/vectorix/license.png)](https://packagist.org/packages/nubs/vectorix)

[![Dependency Status](https://www.versioneye.com/user/projects/534eb34bfe0d071c050007ac/badge.png)](https://www.versioneye.com/user/projects/534eb34bfe0d071c050007ac)

## Requirements
This library requires PHP 5.3, or newer.

## Installation
This package uses [composer](https://getcomposer.org) so you can just add
`nubs\vectorix` as a dependency to your `composer.json` file.

## Vector
The [`Vector`](src/Vector.php) class represents an immutable [Euclidean
vector](http://en.wikipedia.org/wiki/Euclidean_vector) and its associated
operations.

All operations on the vector will return a new vector with the results.  For
example,
```php
$a = new \Nubs\Vectorix\Vector([1, 5]);
$b = $a->multiplyByScalar(2);

// $a is not changed.  Once a vector is created, it is immutable.
assert($a->components() === [1, 5]);

// Results of operations (like multiplyByScalar) are returned where they can be
// used.
assert($b->components() === [2, 10]);
```

The keys of a vector's components are preserved through operations.  Because of
this, vectors MUST have the same keys in order to use them together.  For
example,
```php
$a = new \Nubs\Vectorix\Vector(['i' => 5, 'j' => 9]);
$b = new \Nubs\Vectorix\Vector(['i' => 1, 'j' => 2]);

$c = $a->add($b);
var_dump($c->components());
// array(2) {
//   'i' =>
//   int(6)
//   'j' =>
//   int(11)
// }

$d = new \Nubs\Vectorix\Vector([5, 9]);

$e = $c->subtract($d);
// PHP Fatal error:  Uncaught exception 'Exception' with message 'The vectors' components must have the same keys'
```

### Creating a Vector

#### Constructor
```php
/*
 * @param array<int|float> $components The components of the vector.
 */
public function __construct(array $components)
```
The primary method for creating a vector is, of course, the constructor.  It
takes an array of the components of the vector (e.g., *x*, *y*, and *z*
components).  Components can be integers, floats, or a combination thereof.

```php
// Create a 3-dimensional vector.
$a = new \Nubs\Vectorix\Vector([2, 3, -1]);

// Create a 2-dimension vector with named components.
$b = new \Nubs\Vectorix\Vector(['x' => 1.7, 'y' => -5.3]);
```

#### Null Vectors
```php
/*
 * @param int $dimension The dimension of the vector to create.  Must be at least 0.
 * @return self The zero-length vector for the given dimension.
 * @throws Exception if the dimension is less than zero.
 */
public static function nullVector($dimension)
```

When needing a [null vector](http://en.wikipedia.org/wiki/Null_vector) (a
vector with zero magnitude), this static method makes creating one easy.  All
of its components will be initialized to the integer `0`.
```php
$a = \Nubs\Vectorix\Vector::nullVector(3);
var_dump($a->components());
// array(3) {
//   [0] =>
//   int(0)
//   [1] =>
//   int(0)
//   [2] =>
//   int(0)
// }
```

### Properties of a Vector

#### Components
```php
/*
 * @return array<int|float> The components of the vector.
 */
public function components()
```

The `components` method returns the components of the vector with keys kept
intact. 
```php
$a = new \Nubs\Vectorix\Vector([7, 4]);
var_dump($a->components());
// array(2) {
//   [0] =>
//   int(7)
//   [1] =>
//   int(4)
// }
```

#### Dimension
```php
/*
 * @return int The dimension/cardinality of the vector.
 */
public function dimension()
```

The `dimension` of a vector is the number of components in it.  This is also
referred to as "cardinality".
```php
$a = new \Nubs\Vectorix\Vector([5.2, 1.4]);
var_dump($a->dimension());
// int(2)
```

#### Length
```php
/*
 * @return float The length/magnitude of the vector.
 */
public function length()
```

The `length`, or
[magnitude](http://en.wikipedia.org/wiki/Magnitude_%28mathematics%29) of a
vector is the distance from the origin to the point described by the vector.

It is always returned as a floating point number.
```php
$a = new \Nubs\Vectorix\Vector([3, 4]);
var_dump($a->length());
// double(5)
```

### Tests

#### Equality
```php
/*
 * @param self $b The vector to check for equality.
 * @return bool True if the vectors are equal and false otherwise.
 */
public function isEqual(self $b)
```

The `isEqual` method tests to see if the two vectors are equal.  They are only
equal if their components are identical (including same keys).
```php
$a = new \Nubs\Vectorix\Vector([1, 2]);
$b = new \Nubs\Vectorix\Vector([1, 2]);
$b = new \Nubs\Vectorix\Vector([5, 7]);

var_dump($a->isEqual($b));
// bool(true)

var_dump($a->isEqual($c));
// bool(false)
```

### Basic Operations

#### Addition

#### Subtraction

#### Scalar Multiplication

#### Scalar Division

#### Dot Product

#### Cross Product

### Other Operations

#### Normalization

#### Projection

#### Scalar Triple Product

#### Vector Triple Product

#### Angle Between Vectors
