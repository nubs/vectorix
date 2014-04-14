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
        if ($this->dimension() !== $b->dimension()) {
            throw new Exception('The vectors must be of the same dimension');
        }

        if (array_keys($this->components()) !== array_keys($b->components())) {
            throw new Exception('The vectors\' components must have the same keys');
        }
    }
}
