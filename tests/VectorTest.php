<?php
namespace Nubs\Vectorix;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Nubs\Vectorix\Vector
 */
class VectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Verify that getComponents returns the same components the vector was
     * constructed with.
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
     * Verify that a zero-length vector has zero length.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::zeroLengthVector
     */
    public function zeroLengthVectorHasZeroLength()
    {
        $vector = Vector::zeroLengthVector(3);
        $this->assertSame(0.0, $vector->length());
    }

    /**
     * Verify that a zero-length, zero-dimensional vector has zero length.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::zeroLengthVector
     */
    public function zeroLengthZeroDimensionalVectorHasZeroLength()
    {
        $vector = Vector::zeroLengthVector(0);
        $this->assertSame(0.0, $vector->length());
    }

    /**
     * Verify that a negative dimension fails for zeroLengthVector.
     *
     * @test
     * @covers ::zeroLengthVector
     * @expectedException Exception
     * @expectedExceptionMessage Dimension must be zero or greater
     */
    public function zeroLengthVectorOfNegativeDimension()
    {
        Vector::zeroLengthVector(-5);
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
     * Verify that addition fails with vectors whose components' keys don't
     * match.
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
     * Verify that subtraction works as expected.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::add
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::subtract
     * @covers ::_checkVectorSpace
     */
    public function subtractAnotherVector()
    {
        $a = new Vector(array(4, 5, 6));
        $b = new Vector(array(1, 2, 3));
        $this->assertSame(array(3, 3, 3), $a->subtract($b)->components());
    }

    /**
     * Verify that subtraction works with 0-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::add
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::subtract
     * @covers ::_checkVectorSpace
     */
    public function subtractZeroDimensionalVectors()
    {
        $a = new Vector(array());
        $b = new Vector(array());
        $this->assertSame(array(), $a->subtract($b)->components());
    }

    /**
     * Verify that subtraction fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::add
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::subtract
     * @covers ::_checkVectorSpace
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function subtractVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(4, 5, 6));
        $b = new Vector(array(1, 2));
        $a->subtract($b);
    }

    /**
     * Verify that subtraction fails with vectors whose components' keys don't
     * match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::add
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::subtract
     * @covers ::_checkVectorSpace
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function subtractVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(4, 5, 6));
        $b = new Vector(array('x' => 1, 'y' => 2, 'z' => 3));
        $a->subtract($b);
    }

    /**
     * Verify that the dot product of two simple vectors works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     */
    public function dotProductOfSimpleVectors()
    {
        $a = new Vector(array(1, 3, -5));
        $b = new Vector(array(4, -2, -1));
        $this->assertSame(3, $a->dotProduct($b));
    }

    /**
     * Verify the dot product of two perpendicular vectors is zero.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     */
    public function dotProductOfPerpendicularVectors()
    {
        $a = new Vector(array(4, 4));
        $b = new Vector(array(4, -4));
        $this->assertSame(0, $a->dotProduct($b));
    }

    /**
     * Verify the dot product of two codirectional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     */
    public function dotProductOfCodirectionalVectors()
    {
        $a = new Vector(array(2, 2));
        $b = new Vector(array(8, 8));
        $this->assertSame(32, $a->dotProduct($b));
    }

    /**
     * Verify the dot product of two 0-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     */
    public function dotProductOfZeroDimensionalVectors()
    {
        $a = new Vector(array());
        $b = new Vector(array());
        $this->assertSame(0, $a->dotProduct($b));
    }

    /**
     * Verify the dot product of a zero-length vector works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     */
    public function dotProductOfZeroLengthVectors()
    {
        $a = new Vector(array(2, 3));
        $b = new Vector(array(0, 0));
        $this->assertSame(0, $a->dotProduct($b));
    }

    /**
     * Verify that dot product fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function dotProductVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array(4, 5));
        $a->dotProduct($b);
    }

    /**
     * Verify that dot product fails with vectors whose components' keys don't
     * match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::dotProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function dotProductVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array('x' => 4, 'y' => 5, 'z' => 6));
        $a->dotProduct($b);
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

    /**
     * Verify that division by a scalar works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @covers ::divideByScalar
     */
    public function divideByScalarWithSimpleValue()
    {
        $a = new Vector(array(4, 8));
        $resultComponents = $a->divideByScalar(4)->components();
        $this->assertEquals(1.0, $resultComponents[0], '', 1e-10);
        $this->assertEquals(2.0, $resultComponents[1], '', 1e-10);
    }

    /**
     * Verify that division by a scalar works for a 0-dimensional vector.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @covers ::divideByScalar
     */
    public function divideByScalarWithZeroDimensionalVector()
    {
        $a = new Vector(array());
        $this->assertSame(array(), $a->divideByScalar(3)->components());
    }

    /**
     * Verify that division by zero throws an exception.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @covers ::divideByScalar
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function divideByScalarZero()
    {
        $a = new Vector(array(4, 8));
        $a->divideByScalar(0);
    }

    /**
     * Verify that normalization works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::normalize
     */
    public function normalizeSimpleVector()
    {
        $a = new Vector(array(1, 1));
        $resultComponents = $a->normalize()->components();
        $this->assertEquals(sqrt(2) / 2, $resultComponents[0], '', 1e-10);
        $this->assertEquals(sqrt(2) / 2, $resultComponents[1], '', 1e-10);
    }

    /**
     * Verify that normalization of a 0-dimensional vector throws an exception.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::normalize
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function normalizeZeroDimensionalVector()
    {
        $a = new Vector(array());
        $a->normalize();
    }

    /**
     * Verify that normalization of a 0-length vector throws an exception.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::normalize
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function normalizeZeroLengthVector()
    {
        $a = new Vector(array(0, 0, 0));
        $a->normalize();
    }

    /**
     * Verify that a simple vector projection works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::normalize
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::projectOnto
     */
    public function projectOntoSimpleVector()
    {
        $a = new Vector(array(4, 0));
        $b = new Vector(array(3, 3));
        $resultComponents = $a->projectOnto($b)->components();
        $this->assertEquals(2, $resultComponents[0], '', 1e-10);
        $this->assertEquals(2, $resultComponents[1], '', 1e-10);
    }

    /**
     * Verify that a zero-length vector can be projected onto another vector
     * without error.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::normalize
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::projectOnto
     */
    public function projectZeroLengthVectorOntoSimpleVector()
    {
        $a = new Vector(array(0, 0));
        $b = new Vector(array(3, 3));
        $resultComponents = $a->projectOnto($b)->components();
        $this->assertEquals(0, $resultComponents[0], '', 1e-10);
        $this->assertEquals(0, $resultComponents[1], '', 1e-10);
    }

    /**
     * Verify that a vector projection fails onto a zero length vector.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::normalize
     * @covers ::projectOnto
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function projectOntoZeroLengthVector()
    {
        $a = new Vector(array(4, 0));
        $b = new Vector(array(0, 0));
        $a->projectOnto($b);
    }

    /**
     * Verify that a vector projection of different dimension vectors fails.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::normalize
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::projectOnto
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function projectOntoVectorOfDifferentDimension()
    {
        $a = new Vector(array(4, 0));
        $b = new Vector(array(5));
        $a->projectOnto($b);
    }

    /**
     * Verify that a vector projection onto a differently keyed vector fails.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::multiplyByScalar
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::normalize
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::projectOnto
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function projectOntoVectorWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(4, 0));
        $b = new Vector(array('x' => 5, 'y' => 7));
        $a->projectOnto($b);
    }
}
