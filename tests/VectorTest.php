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

    /**
     * Verify that addition works as expected.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::add
     * @covers ::_checkVectorSpace
     */
    public function addAnotherVector()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array(4, 5, 6));
        $this->assertSame(array(5, 7, 9), $a->add($b)->components());
    }

    /**
     * Verify that addition works with 0-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::add
     * @covers ::_checkVectorSpace
     */
    public function addZeroDimensionalVectors()
    {
        $a = new Vector(array());
        $b = new Vector(array());
        $this->assertSame(array(), $a->add($b)->components());
    }

    /**
     * Verify that addition fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::add
     * @covers ::_checkVectorSpace
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function addVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array(4, 5));
        $a->add($b);
    }

    /**
     * Verify that addition fails with vectors whose components' keys don't match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::add
     * @covers ::_checkVectorSpace
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function addVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array('x' => 4, 'y' => 5, 'z' => 6));
        $a->add($b);
    }

    /**
     * Verify that multiplication by a scalar works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::multiplyByScalar
     */
    public function multiplyByScalarWithSimpleValue()
    {
        $a = new Vector(array(1, 2, 3));
        $this->assertSame(array(3, 6, 9), $a->multiplyByScalar(3)->components());
    }

    /**
     * Verify that multiplication by a scalar works for a 0-dimensional vector.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::multiplyByScalar
     */
    public function multiplyByScalarWithZeroDimensionalVector()
    {
        $a = new Vector(array());
        $this->assertSame(array(), $a->multiplyByScalar(3)->components());
    }
}
