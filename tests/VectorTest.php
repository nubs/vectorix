<?php
namespace Nubs\Vectorix;

use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass \Nubs\Vectorix\Vector
 */
class VectorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Verify that components() returns the same components the vector was
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
     * @covers ::nullVector
     */
    public function nullVectorHasZeroLength()
    {
        $vector = Vector::nullVector(3);
        $this->assertSame(0.0, $vector->length());
    }

    /**
     * Verify that a zero-length, zero-dimensional vector has zero length.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::nullVector
     */
    public function nullZeroDimensionalVectorHasZeroLength()
    {
        $vector = Vector::nullVector(0);
        $this->assertSame(0.0, $vector->length());
    }

    /**
     * Verify that a negative dimension fails for nullVector.
     *
     * @test
     * @covers ::nullVector
     * @expectedException Exception
     * @expectedExceptionMessage Dimension must be zero or greater
     */
    public function nullVectorOfNegativeDimension()
    {
        Vector::nullVector(-5);
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
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::length
     */
    public function lengthOfZeroDimensionalVector()
    {
        $vector = Vector::nullVector(0);
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
     * Verify that 2 equal-dimension vectors are considered the same dimension.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @covers ::isSameDimension
     */
    public function isSameDimensionWithSameDimensionalVectors()
    {
        $a = new Vector(array(-1, 4, 1));
        $b = new Vector(array(4, -9.3, 2.1));
        $this->assertTrue($a->isSameDimension($b), 'Vectors with same-dimension are considered same dimension');
    }

    /**
     * Verify that 2 different-dimension vectors are not considered the same
     * dimension.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @covers ::isSameDimension
     */
    public function isSameDimensionWithDifferentDimensionalVectors()
    {
        $a = new Vector(array(1, 3));
        $b = new Vector(array(4, 7, 1));
        $this->assertFalse($a->isSameDimension($b), 'Vectors with different-dimension components are not considered same dimension');
    }

    /**
     * Verify that 2 same vector space vectors are considered the same vector
     * space.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::isSameVectorSpace
     */
    public function isSameVectorSpaceWithSameVectorSpaceVectors()
    {
        $a = new Vector(array('x' => -1, 'y' => 4, 'z' => 1));
        $b = new Vector(array('x' => 4, 'y' => -9.3, 'z' => 2.1));
        $this->assertTrue($a->isSameVectorSpace($b), 'Vectors with same vector space are considered same vector space');
    }

    /**
     * Verify that 2 different-dimension vectors are not considered the same
     * vector space.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::isSameVectorSpace
     */
    public function isSameVectorSpaceWithDifferentDimensionalVectors()
    {
        $a = new Vector(array(1, 3));
        $b = new Vector(array(4, 7, 1));
        $this->assertFalse($a->isSameVectorSpace($b), 'Vectors with different-dimension components are not considered same vector space');
    }

    /**
     * Verify that 2 differently keyed vectors are not considered the same
     * vector space.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @covers ::isSameVectorSpace
     */
    public function isSameVectorSpaceWithDifferentKeyedVectors()
    {
        $a = new Vector(array(1, 2, 3));
        $b = new Vector(array('x' => 4, 'y' => 7, 'z' => 1));
        $this->assertFalse($a->isSameVectorSpace($b), 'Vectors with differently keyed components are not considered same vector space');
    }

    /**
     * Verify that addition works as expected.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::add
     * @covers ::_checkVectorSpace
     */
    public function addZeroDimensionalVectors()
    {
        $a = Vector::nullVector(0);
        $b = Vector::nullVector(0);
        $this->assertSame(array(), $a->add($b)->components());
    }

    /**
     * Verify that addition fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::subtract
     * @covers ::_checkVectorSpace
     */
    public function subtractZeroDimensionalVectors()
    {
        $a = Vector::nullVector(0);
        $b = Vector::nullVector(0);
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::dotProduct
     */
    public function dotProductOfZeroDimensionalVectors()
    {
        $a = Vector::nullVector(0);
        $b = Vector::nullVector(0);
        $this->assertSame(0, $a->dotProduct($b));
    }

    /**
     * Verify the dot product of a zero-length vector works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::dotProduct
     */
    public function dotProductOfNullVectors()
    {
        $a = new Vector(array(2, 3));
        $b = Vector::nullVector(2);
        $this->assertSame(0, $a->dotProduct($b));
    }

    /**
     * Verify that dot product fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * Verify that the cross product of two simple vectors works.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::crossProduct
     */
    public function crossProductOfSimpleVectors()
    {
        $a = new Vector(array(2, 3, 4));
        $b = new Vector(array(5, 6, 7));
        $this->assertSame(array(-3, 6, -3), $a->crossProduct($b)->components());
    }

    /**
     * Verify that the cross product of two codirectional vectors is a null
     * vector.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::crossProduct
     */
    public function crossProductOfCodirectionalVectors()
    {
        $a = new Vector(array(2, 2, 2));
        $b = new Vector(array(8, 8, 8));
        $this->assertSame(array(0, 0, 0), $a->crossProduct($b)->components());
    }

    /**
     * Verify that cross product fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::crossProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function crossProductVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(2, 5, 7));
        $b = new Vector(array(1, 8));
        $a->crossProduct($b);
    }

    /**
     * Verify that cross product fails with vectors whose components' keys don't
     * match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::crossProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function crossProductVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(3, 2, 8));
        $b = new Vector(array('x' => 8, 'y' => 9, 'z' => 0));
        $a->crossProduct($b);
    }

    /**
     * Verify that cross product fails with two-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @covers ::crossProduct
     * @expectedException Exception
     * @expectedExceptionMessage Both vectors must be 3-dimensional
     */
    public function crossProductOfTwoDimensionalVectors()
    {
        $a = new Vector(array(7, 2));
        $b = new Vector(array(1, 9));
        $a->crossProduct($b);
    }

    /**
     * Verify that the scalar triple product works with simple vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::scalarTripleProduct
     */
    public function scalarTripleProductOfSimpleVectors()
    {
        $a = new Vector(array(-2, 3, 1));
        $b = new Vector(array(0, 4, 0));
        $c = new Vector(array(-1, 3, 3));
        $this->assertSame(-20, $a->scalarTripleProduct($b, $c));
    }

    /**
     * Verify that the scalar triple product of two codirectional vectors is 0.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::scalarTripleProduct
     */
    public function scalarTripleProductOfCodirectionalVectors()
    {
        $a = new Vector(array(2, 2, 2));
        $b = new Vector(array(8, 8, 8));
        $c = new Vector(array(1, 1, 1));
        $this->assertSame(0, $a->scalarTripleProduct($b, $c));
    }

    /**
     * Verify that scalar triple product fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::scalarTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function scalarTripleProductVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(2, 5, 7));
        $b = new Vector(array(1, 8));
        $c = new Vector(array(1, 8, 9, 14));
        $a->scalarTripleProduct($b, $c);
    }

    /**
     * Verify that scalar triple product fails with vectors whose components'
     * keys don't match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::scalarTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function scalarTripleProductVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(3, 2, 8));
        $b = new Vector(array('x' => 8, 'y' => 9, 'z' => 0));
        $c = new Vector(array('i' => 8, 'j' => 9, 'k' => 0));
        $a->scalarTripleProduct($b, $c);
    }

    /**
     * Verify that scalar triple product fails with two-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::scalarTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage Both vectors must be 3-dimensional
     */
    public function scalarTripleProductOfTwoDimensionalVectors()
    {
        $a = new Vector(array(7, 2));
        $b = new Vector(array(1, 9));
        $c = new Vector(array(0, 5));
        $a->scalarTripleProduct($b, $c);
    }

    /**
     * Verify that the vector triple product works with simple vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::vectorTripleProduct
     */
    public function vectorTripleProductOfSimpleVectors()
    {
        $a = new Vector(array(-2, 3, 1));
        $b = new Vector(array(0, 4, 0));
        $c = new Vector(array(-1, 3, 3));
        $this->assertSame(array(12, 20, -36), $a->vectorTripleProduct($b, $c)->components());
    }

    /**
     * Verify that the vector triple product of two codirectional vectors is 0.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::vectorTripleProduct
     */
    public function vectorTripleProductOfCodirectionalVectors()
    {
        $a = new Vector(array(2, 2, 2));
        $b = new Vector(array(8, 8, 8));
        $c = new Vector(array(1, 1, 1));
        $this->assertSame(array(0, 0, 0), $a->vectorTripleProduct($b, $c)->components());
    }

    /**
     * Verify that vector triple product fails with different dimension vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::vectorTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function vectorTripleProductVectorsOfDifferentDimensions()
    {
        $a = new Vector(array(2, 5, 7));
        $b = new Vector(array(1, 8));
        $c = new Vector(array(1, 8, 9, 14));
        $a->vectorTripleProduct($b, $c);
    }

    /**
     * Verify that vector triple product fails with vectors whose components'
     * keys don't match.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::vectorTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function vectorTripleProductVectorsWithDifferentlyKeyedComponents()
    {
        $a = new Vector(array(3, 2, 8));
        $b = new Vector(array('x' => 8, 'y' => 9, 'z' => 0));
        $c = new Vector(array('i' => 8, 'j' => 9, 'k' => 0));
        $a->vectorTripleProduct($b, $c);
    }

    /**
     * Verify that vector triple product fails with two-dimensional vectors.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::crossProduct
     * @covers ::vectorTripleProduct
     * @expectedException Exception
     * @expectedExceptionMessage Both vectors must be 3-dimensional
     */
    public function vectorTripleProductOfTwoDimensionalVectors()
    {
        $a = new Vector(array(7, 2));
        $b = new Vector(array(1, 9));
        $c = new Vector(array(0, 5));
        $a->vectorTripleProduct($b, $c);
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
        $vector = new Vector(array(1, 2, 3));
        $this->assertSame(array(3, 6, 9), $vector->multiplyByScalar(3)->components());
    }

    /**
     * Verify that multiplication by a scalar works for a 0-dimensional vector.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::multiplyByScalar
     */
    public function multiplyByScalarWithZeroDimensionalVector()
    {
        $vector = Vector::nullVector(0);
        $this->assertSame(array(), $vector->multiplyByScalar(3)->components());
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
        $vector = new Vector(array(4, 8));
        $resultComponents = $vector->divideByScalar(4)->components();
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
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::divideByScalar
     */
    public function divideByScalarWithZeroDimensionalVector()
    {
        $vector = Vector::nullVector(0);
        $this->assertSame(array(), $vector->divideByScalar(3)->components());
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
        $vector = new Vector(array(4, 8));
        $vector->divideByScalar(0);
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
        $vector = new Vector(array(1, 1));
        $resultComponents = $vector->normalize()->components();
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
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::normalize
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function normalizeZeroDimensionalVector()
    {
        $vector = Vector::nullVector(0);
        $vector->normalize();
    }

    /**
     * Verify that normalization of a 0-length vector throws an exception.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::divideByScalar
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::normalize
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function normalizeNullVector()
    {
        $vector = Vector::nullVector(3);
        $vector->normalize();
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::projectOnto
     */
    public function projectNullVectorOntoSimpleVector()
    {
        $a = Vector::nullVector(2);
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
     * @uses \Nubs\Vectorix\Vector::nullVector
     * @covers ::projectOnto
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function projectOntoNullVector()
    {
        $a = new Vector(array(4, 0));
        $b = Vector::nullVector(2);
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
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

    /**
     * Verify that the angle between two vectors is computed correctly.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::angleBetween
     */
    public function angleBetweenSimpleVectors()
    {
        $a = new Vector(array(0, 5));
        $b = new Vector(array(3, 3));
        $this->assertEquals(M_PI / 4, $a->angleBetween($b), '', 1e-10);
    }

    /**
     * Verify that the angle between a vector and a zero-length vector fails.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::length
     * @covers ::angleBetween
     * @expectedException Exception
     * @expectedExceptionMessage Cannot divide by zero
     */
    public function angleBetweenZeroLengthVector()
    {
        $a = new Vector(array(2, 4));
        $b = new Vector(array(0, 0));
        $a->angleBetween($b);
    }

    /**
     * Verify that the angle between vectors of different dimensions fails.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::angleBetween
     * @expectedException Exception
     * @expectedExceptionMessage The vectors must be of the same dimension
     */
    public function angleBetweenVectorsOfDifferentDimension()
    {
        $a = new Vector(array(2, 4));
        $b = new Vector(array(3));
        $a->angleBetween($b);
    }

    /**
     * Verify that the angle between vectors of differently keyed components
     * fails.
     *
     * @test
     * @uses \Nubs\Vectorix\Vector::__construct
     * @uses \Nubs\Vectorix\Vector::components
     * @uses \Nubs\Vectorix\Vector::dimension
     * @uses \Nubs\Vectorix\Vector::isSameDimension
     * @uses \Nubs\Vectorix\Vector::isSameVectorSpace
     * @uses \Nubs\Vectorix\Vector::_checkVectorSpace
     * @uses \Nubs\Vectorix\Vector::length
     * @uses \Nubs\Vectorix\Vector::dotProduct
     * @covers ::angleBetween
     * @expectedException Exception
     * @expectedExceptionMessage The vectors' components must have the same keys
     */
    public function angleBetweenDifferentlyKeyedVectors()
    {
        $a = new Vector(array(2, 4));
        $b = new Vector(array('x' => 3, 'y' => 7));
        $a->angleBetween($b);
    }
}
