<?php
namespace Nubs\Vectorix;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Nubs\Vectorix\Vector
 */
class VectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Verify that getComponents returns the same components the vector was constructed with.
     *
     * In particular, this makes sure that the keys are left alone.
     *
     * @test
     * @covers ::__construct
     * @covers ::components
     */
    public function componentsMaintainStructure()
    {
        $components = array(5, 2.4, 'z' => 1.773);
        $vector = new Vector($components);

        $this->assertSame($components, $vector->components());
    }

    /**
     * Verify that the dimension of the vector is correct.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::dimension
     */
    public function dimensionIsCorrect()
    {
        $vector = new Vector(array(1, 0, 0));
        $this->assertSame(3, $vector->dimension());
    }

    /**
     * Verify that the length of the vector is correct.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::length
     */
    public function lengthIsCorrect()
    {
        $vector = new Vector(array(3, 4));
        $this->assertEquals(5.0, $vector->length(), '', 1e-10);
    }

    /**
     * Verify that the length of a 0-dimensional vector is correct.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::length
     */
    public function lengthOfZeroDimensionalVector()
    {
        $vector = new Vector(array());
        $this->assertEquals(0.0, $vector->length(), '', 1e-10);
    }

    /**
     * Verify that 2 equal vectors are considered the same.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::isEqual
     */
    public function isEqualWithSameVectors()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array(1, 2, 3));
        $this->assertTrue($a->isEqual($b), 'Vectors with same components are equal');
    }

    /**
     * Verify that 2 different vectors are not considered the same.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::isEqual
     */
    public function isEqualWithDifferentVectors()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array(9, 2, 3));
        $this->assertFalse($a->isEqual($b), 'Vectors with different components are not equal');
    }
}
