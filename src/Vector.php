<?php
namespace Nubs\Vectorix;

use Exception;

/**
 * This class represents an immutable Euclidean vector and its associated
 * operations.
 *
 * Instances of this class will not change state.  Any operations on the vector
 * will return a new vector with the new state.
 */
class Vector
{
    /** @type array<int|float> The components of the vector. */
    protected $_components;

    /**
     * Initialize the vector with its components.
     *
     * @api
     * @param array<int|float> $components The components of the vector.
     */
    public function __construct(array $components)
    {
        $this->_components = $components;
    }

    /**
     * Creates a null/zero-length vector of the given dimension.
     *
     * @api
     * @param int $dimension The dimension of the vector to create.  Must be at least 0.
     * @return self The zero-length vector for the given dimension.
     * @throws Exception if the dimension is less than zero.
     */
    public static function nullVector($dimension)
    {
        if ($dimension < 0) {
            throw new Exception('Dimension must be zero or greater');
        }

        if ($dimension === 0) {
            return new static(array());
        }

        return new static(array_fill(0, $dimension, 0));
    }

    /**
     * Get the components of the vector.
     *
     * @api
     * @return array<int|float> The components of the vector.
     */
    public function components()
    {
        return $this->_components;
    }

    /**
     * Get the dimension/cardinality of the vector.
     *
     * @api
     * @return int The dimension/cardinality of the vector.
     */
    public function dimension()
    {
        return count($this->components());
    }

    /**
     * Returns the length of the vector.
     *
     * @api
     * @return float The length/magnitude of the vector.
     */
    public function length()
    {
        $sumOfSquares = 0;
        foreach ($this->components() as $component) {
            $sumOfSquares += pow($component, 2);
        }

        return sqrt($sumOfSquares);
    }

    /**
     * Check whether the given vector is the same as this vector.
     *
     * @api
     * @param self $b The vector to check for equality.
     * @return bool True if the vectors are equal and false otherwise.
     */
    public function isEqual(self $b)
    {
        return $this->components() === $b->components();
    }

    /**
     * Checks whether the two vectors are of the same dimension.
     *
     * @api
     * @param self $b The vector to check against.
     * @return bool True if the vectors are of the same dimension, false otherwise.
     */
    public function isSameDimension(self $b)
    {
        return $this->dimension() === $b->dimension();
    }

    /**
     * Checks whether the two vectors are of the same vector space.
     *
     * @api
     * @param self $b The vector to check against.
     * @return bool True if the vectors are the same vector space, false otherwise.
     */
    public function isSameVectorSpace(self $b)
    {
        return array_keys($this->components()) === array_keys($b->components());
    }

    /**
     * Adds two vectors together.
     *
     * @api
     * @param self $b The vector to add.
     * @return self The sum of the two vectors.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function add(self $b)
    {
        $this->_checkVectorSpace($b);

        $bComponents = $b->components();
        $sum = array();
        foreach ($this->components() as $i => $component) {
            $sum[$i] = $component + $bComponents[$i];
        }

        return new static($sum);
    }

    /**
     * Subtracts the given vector from this vector.
     *
     * @api
     * @param self $b The vector to subtract from this vector.
     * @return self The difference of the two vectors.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function subtract(self $b)
    {
        return $this->add($b->multiplyByScalar(-1));
    }

    /**
     * Computes the dot product, or scalar product, of two vectors.
     *
     * @api
     * @param self $b The vector to multiply with.
     * @return int|float The dot product of the two vectors.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function dotProduct(self $b)
    {
        $this->_checkVectorSpace($b);

        $bComponents = $b->components();
        $product = 0;
        foreach ($this->components() as $i => $component) {
            $product += $component * $bComponents[$i];
        }

        return $product;
    }

    /**
     * Computes the cross product, or vector product, of two vectors.
     *
     * @api
     * @param self $b The vector to multiply with.
     * @return self The cross product of the two vectors.
     * @throws Exception if the vectors are not 3-dimensional.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function crossProduct(self $b)
    {
        $this->_checkVectorSpace($b);
        if ($this->dimension() !== 3) {
            throw new Exception('Both vectors must be 3-dimensional');
        }

        $tc = $this->components();
        $bc = $b->components();
        list($k0, $k1, $k2) = array_keys($tc);
        $product = array(
            $k0 => $tc[$k1] * $bc[$k2] - $tc[$k2] * $bc[$k1],
            $k1 => $tc[$k2] * $bc[$k0] - $tc[$k0] * $bc[$k2],
            $k2 => $tc[$k0] * $bc[$k1] - $tc[$k1] * $bc[$k0],
        );

        return new static($product);
    }

    /**
     * Computes the scalar triple product of three vectors.
     *
     * @api
     * @param self $b The second vector of the triple product.
     * @param self $c The third vector of the triple product.
     * @return int|float The scalar triple product of the three vectors.
     * @throws Exception if the vectors are not 3-dimensional.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function scalarTripleProduct(self $b, self $c)
    {
        return $this->dotProduct($b->crossProduct($c));
    }

    /**
     * Computes the vector triple product of three vectors.
     *
     * @api
     * @param self $b The second vector of the triple product.
     * @param self $c The third vector of the triple product.
     * @return self The vector triple product of the three vectors.
     * @throws Exception if the vectors are not 3-dimensional.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function vectorTripleProduct(self $b, self $c)
    {
        return $this->crossProduct($b->crossProduct($c));
    }

    /**
     * Multiplies the vector by the given scalar.
     *
     * @api
     * @param int|float $scalar The real number to multiply by.
     * @return self The result of the multiplication.
     */
    public function multiplyByScalar($scalar)
    {
        $result = array();
        foreach ($this->components() as $i => $component) {
            $result[$i] = $component * $scalar;
        }

        return new static($result);
    }

    /**
     * Divides the vector by the given scalar.
     *
     * @api
     * @param int|float $scalar The real number to divide by.
     * @return self The result of the division.
     * @throws Exception if the $scalar is 0.
     */
    public function divideByScalar($scalar)
    {
        if ($scalar == 0) {
            throw new Exception('Cannot divide by zero');
        }

        return $this->multiplyByScalar(1.0 / $scalar);
    }

    /**
     * Return the normalized vector.
     *
     * The normalized vector (or unit vector) is the vector with the same
     * direction as this vector, but with a length/magnitude of 1.
     *
     * @api
     * @return self The normalized vector.
     * @throws Exception if the vector length is zero.
     */
    public function normalize()
    {
        return $this->divideByScalar($this->length());
    }

    /**
     * Project the vector onto another vector.
     *
     * @api
     * @param self $b The vector to project this vector onto.
     * @return self The vector projection of this vector onto $b.
     * @throws Exception if the vector length of $b is zero.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function projectOnto(self $b)
    {
        $bUnit = $b->normalize();
        return $bUnit->multiplyByScalar($this->dotProduct($bUnit));
    }

    /**
     * Returns the angle between the two vectors.
     *
     * @api
     * @param self $b The vector to compute the angle between.
     * @return float The angle between the two vectors in radians.
     * @throws Exception if either of the vectors are zero-length.
     * @throws Exception if the vectors are not in the same vector space.
     * @see self::_checkVectorSpace() For exception information.
     */
    public function angleBetween(self $b)
    {
        $denominator = $this->length() * $b->length();
        if ($denominator == 0) {
            throw new Exception('Cannot divide by zero');
        }

        return acos($this->dotProduct($b) / $denominator);
    }

    /**
     * Checks that the vector spaces of the two vectors are the same.
     *
     * The vectors must be of the same dimension and have the same keys in their
     * components.
     *
     * @internal
     * @param self $b The vector to check against.
     * @return void
     * @throws Exception if the vectors are not of the same dimension.
     * @throws Exception if the vectors' components down have the same keys.
     */
    protected function _checkVectorSpace(self $b)
    {
        if (!$this->isSameDimension($b)) {
            throw new Exception('The vectors must be of the same dimension');
        }

        if (!$this->isSameVectorSpace($b)) {
            throw new Exception('The vectors\' components must have the same keys');
        }
    }
}
