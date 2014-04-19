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
