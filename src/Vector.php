<?php
namespace Nubs\Vectorix;

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
}
