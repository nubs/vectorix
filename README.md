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
/**
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
/**
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
/**
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
/**
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
/**
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
/**
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
$c = new \Nubs\Vectorix\Vector([5, 7]);

var_dump($a->isEqual($b));
// bool(true)

var_dump($a->isEqual($c));
// bool(false)
```

#### Same Dimension
```php
/**
 * @param self $b The vector to check against.
 * @return bool True if the vectors are of the same dimension, false otherwise.
 */
public function isSameDimension(self $b)
```

The `isSameDimension` method tests to see if the two vectors both have the same
dimension.
```php
$a = new \Nubs\Vectorix\Vector([1, 2]);
$b = new \Nubs\Vectorix\Vector([5, 1]);
$c = new \Nubs\Vectorix\Vector([5, 8, 2]);

var_dump($a->isSameDimension($b));
// bool(true)

var_dump($a->isSameDimension($c));
// bool(false)
```

#### Same Vector Space
```php
/**
 * @param self $b The vector to check against.
 * @return bool True if the vectors are the same vector space, false otherwise.
 */
public function isSameVectorSpace(self $b)
```

The `isSameVectorSpace` method tests to see if the two vectors both belong to
the same vector space.

The vector space is defined in this library by the dimension of the vectors,
and the keys of the vectors' components.
```php
$a = new \Nubs\Vectorix\Vector([1, 2]);
$b = new \Nubs\Vectorix\Vector([5, 1]);
$c = new \Nubs\Vectorix\Vector([2, 1, 7]);
$d = new \Nubs\Vectorix\Vector(['x' => 3, 'y' => 2]);

var_dump($a->isSameVectorSpace($b));
// bool(true)

var_dump($a->isSameVectorSpace($c));
// bool(false)

var_dump($a->isSameVectorSpace($d));
// bool(false)
```

### Basic Operations

#### Addition
```php
/**
 * @param self $b The vector to add.
 * @return self The sum of the two vectors.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function add(self $b)
```

The `add` method performs vector
[addition](http://en.wikipedia.org/wiki/Euclidean_vector#Addition_and_subtraction).
The two vectors must belong to the same vector space.

The result is a new vector where each component is the sum of the corresponding
components in the two vectors.
```php
$a = new \Nubs\Vectorix\Vector([7, -2]);
$b = new \Nubs\Vectorix\Vector([-1, 5]);

$c = $a->add($b);
var_dump($c->components());
// array(2) {
//   [0] =>
//   int(6)
//   [1] =>
//   int(3)
// }
```

#### Subtraction
```php
/**
 * @param self $b The vector to subtract from this vector.
 * @return self The difference of the two vectors.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function subtract(self $b)
```

The `subtract` method performs vector
[subtraction](http://en.wikipedia.org/wiki/Euclidean_vector#Addition_and_subtraction).
The two vectors must belong to the same vector space.

The result is a new vector where each component is the difference of the
corresponding components in the two vectors
```php
$a = new \Nubs\Vectorix\Vector([5, 7]);
$b = new \Nubs\Vectorix\Vector([-1, 6]);

$c = $a->subtract($b);
var_dump($c->components());
// array(2) {
//   [0] =>
//   int(6)
//   [1] =>
//   int(1)
// }
```

#### Scalar Multiplication
```php
/**
 * @param int|float $scalar The real number to multiply by.
 * @return self The result of the multiplication.
 */
public function multiplyByScalar($scalar)
```

The `multiplyByScalar` function performs [scalar
multiplication](http://en.wikipedia.org/wiki/Euclidean_vector#Scalar_multiplication)
of a vector with a scalar value.

The result is a new vector where each component is the multiplication of that
component with the scalar value.
```php
$a = new \Nubs\Vectorix\Vector([2, 8, -1]);
$b = 5;

$c = $a->multiplyByScalar($b);
var_dump($c->components());
// array(3) {
//   [0] =>
//   int(10)
//   [1] =>
//   int(40)
//   [2] =>
//   int(-5)
// }
```

#### Scalar Division
```php
/**
 * @param int|float $scalar The real number to divide by.
 * @return self The result of the division.
 * @throws Exception if the $scalar is 0.
 */
public function divideByScalar($scalar)
```

The `divideByScalar` function performs scalar division of a vector with a
scalar value.  This is the same as multiplying the vector by `1 / scalarValue`.

Trying to divide by zero will throw an exception.

The result is a new vector where each component is the division of that
component with the scalar value.
```php
$a = new \Nubs\Vectorix\Vector([4, 12, -8]);
$b = 2;

$c = $a->divideByScalar($b);
var_dump($c->components());
// array(3) {
//   [0] =>
//   double(2)
//   [1] =>
//   double(6)
//   [2] =>
//   double(-4)
// }
```

#### Dot Product
```php
/**
 * @param self $b The vector to multiply with.
 * @return int|float The dot product of the two vectors.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function dotProduct(self $b)
```

The `dotProduct` method performs a [dot
product](http://en.wikipedia.org/wiki/Dot_product) between two vectors.  The
two vectors must belong to the same vector space.
```php
$a = new \Nubs\Vectorix\Vector([1, 3, -5]);
$b = new \Nubs\Vectorix\Vector([4, -2, -1]);
var_dump($a->dotProduct($b));
// int(3)
```

#### Cross Product
```php
/**
 * @param self $b The vector to multiply with.
 * @return self The cross product of the two vectors.
 * @throws Exception if the vectors are not 3-dimensional.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function crossProduct(self $b)
```

The `crossProduct` method computes the [cross
product](http://en.wikipedia.org/wiki/Cross_product) between two
three-dimensional vectors.  The resulting vector is perpendicular to the plane
containing the two vectors.
```php
$a = new \Nubs\Vectorix\Vector([2, 3, 4]);
$b = new \Nubs\Vectorix\Vector([5, 6, 7]);

$c = $a->crossProduct($b);
var_dump($c->components());
// array(3) {
//   [0] =>
//   int(-3)
//   [1] =>
//   int(6)
//   [2] =>
//   int(-3)
// }
```

### Other Operations

#### Normalization
```php
/**
 * @return self The normalized vector.
 * @throws Exception if the vector length is zero.
 */
public function normalize()
```

The `normalize` method returns the [unit
vector](http://en.wikipedia.org/wiki/Unit_vector) with the same direction as
the original vector.
```php
$a = new \Nubs\Vectorix\Vector([3, 3]);
$b = $a->normalize();
var_dump($b->components());
// array(2) {
//   [0] =>
//   double(0.70710678118655)
//   [1] =>
//   double(0.70710678118655)
// }
```

#### Projection
```php
/**
 * @param self $b The vector to project this vector onto.
 * @return self The vector projection of this vector onto $b.
 * @throws Exception if the vector length of $b is zero.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function projectOnto(self $b)
/*
```

The `projectOnto` method computes the [vector
projection](http://en.wikipedia.org/wiki/Vector_projection) of one vector onto
another.  The resulting vector will be colinear with `$b`.
```php
$a = new \Nubs\Vectorix\Vector([4, 0]);
$b = new \Nubs\Vectorix\Vector([3, 3]);

$c = $a->projectOnto($b);
var_dump($c->components());
// array(2) {
//   [0] =>
//   double(2)
//   [1] =>
//   double(2)
// }
```

#### Scalar Triple Product
```php
/**
 * @param self $b The second vector of the triple product.
 * @param self $c The third vector of the triple product.
 * @return int|float The scalar triple product of the three vectors.
 * @throws Exception if the vectors are not 3-dimensional.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function scalarTripleProduct(self $b, self $c)
```

The `scalarTripleProduct` method computes the [scalar triple
product](http://en.wikipedia.org/wiki/Triple_product#Scalar_triple_product).
This value represents the volume of the parallelepiped defined by the three
vectors.

```php
$a = new \Nubs\Vectorix\Vector([-2, 3, 1]);
$b = new \Nubs\Vectorix\Vector([0, 4, 0]);
$c = new \Nubs\Vectorix\Vector([-1, 3, 3]);

var_dump($a->scalarTripleProduct($b, $c));
// int(-20)
```

#### Vector Triple Product
```php
/**
 * @param self $b The second vector of the triple product.
 * @param self $c The third vector of the triple product.
 * @return self The vector triple product of the three vectors.
 * @throws Exception if the vectors are not 3-dimensional.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function vectorTripleProduct(self $b, self $c)
```

The `vectorTripleProduct` method computes the [vector triple
product](http://en.wikipedia.org/wiki/Triple_product#Vector_triple_product).

```php
$a = new \Nubs\Vectorix\Vector([-2, 3, 1]);
$b = new \Nubs\Vectorix\Vector([0, 4, 0]);
$c = new \Nubs\Vectorix\Vector([-1, 3, 3]);

$d = $a->vectorTripleProduct($b, $c);
var_dump($d->components());
// array(3) {
//   [0] =>
//   int(12)
//   [1] =>
//   int(20)
//   [2] =>
//   int(-36)
// }
```

#### Angle Between Vectors
```php
/**
 * @param self $b The vector to compute the angle between.
 * @return float The angle between the two vectors in radians.
 * @throws Exception if either of the vectors are zero-length.
 * @throws Exception if the vectors are not in the same vector space.
 */
public function angleBetween(self $b)
```

The `angleBetween` method computes the angle between two vectors in radians.

```php
$a = new \Nubs\Vectorix\Vector(array(0, 5));
$b = new \Nubs\Vectorix\Vector(array(3, 3));
var_dump($a->angleBetween($b));
// double(0.78539816339745)
```
